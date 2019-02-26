Public Class nrniv
    Private currenttask As String
    Private checkedin As Boolean
    Private isrunning As Boolean
    Private uploadneeded As Boolean
    Private nrniv As Process
    Private nextcontactdate As Date
    Private lastcommand As String
    Private neurontouched As Date
    Private modeldirectory As String
    Private errormessage As String
    Private finishedfile As System.IO.FileInfo
    Private pdone As Double
    Private servermessages As String

    Public ReadOnly Property Work_Finished() As Boolean
        Get
            finishedfile.Refresh()
            Return finishedfile.Exists
        End Get
    End Property

    Public ReadOnly Property Neuron_Touched() As Date
        Get
            Return neurontouched
        End Get
    End Property

    Public ReadOnly Property Checked_In() As Boolean
        Get
            Return checkedin
        End Get
    End Property
    Public Property Current_Task() As String
        Set(ByVal value As String)
            currenttask = Now() & ": " & value & Chr(13) & Chr(10) & currenttask
        End Set
        Get
            Dim holder As String
            holder = currenttask
            currenttask = ""
            Return holder
        End Get
    End Property
    Public Property Server_Messages() As String
        Set(ByVal value As String)
            servermessages = Now() & ": " & value & Chr(13) & Chr(10) & servermessages
        End Set
        Get
            Dim holder As String
            holder = servermessages
            servermessages = ""
            Return holder
        End Get
    End Property
    Public ReadOnly Property Is_Running() As Boolean
        Get
            Return IsRunning
        End Get
    End Property
    Public ReadOnly Property Upload_Needed() As Boolean
        Get
            Return uploadneeded
        End Get
    End Property
    Public ReadOnly Property Next_Contact_Date() As Date
        Get
            Return nextcontactdate
        End Get
    End Property
    Public ReadOnly Property Contact_OK() As Boolean
        Get
            If Next_Contact_Date() < Now() Then Return True Else Return False
        End Get
    End Property
    Public ReadOnly Property Last_Command() As String
        Get
            Return lastcommand
        End Get
    End Property

    Public ReadOnly Property Error_Flag() As Boolean
        Get
            If Error_Message() = Nothing Then Return False Else Return True
        End Get
    End Property

    Public Property Error_Message() As String
        Set(ByVal value As String)
            
            errormessage = Now() & ": " & value & Chr(13) & Chr(10) & errormessage

        End Set
        Get
            Dim holder As String
            holder = errormessage
            errormessage = ""
            Return holder
        End Get
    End Property

    Public ReadOnly Property p_done() As Double
        Get
            Return pdone
        End Get
    End Property


    Public Sub New()
        ' initialize the class
      
        Current_Task() = "Iniializing nueronPM"
        checkedin = False
        isrunning = False
        uploadneeded = False
        pdone = 0
        lastcommand = ""
        nextcontactdate = Now()

        'see if neuron already has a task and if so, be sure it is able to run it
        'neuron_prepare()
        If Trim(My.Settings.modeldir) > "" Then
            modeldirectory = My.Settings.NSweepDir & "\models\" & My.Settings.modeldir
        End If

        Dim taskprogress As System.Collections.Specialized.NameValueCollection = Work_Progress(Val(My.Settings.workstart), Val(My.Settings.blocksize))
        If taskprogress.HasKeys Then
            'yes, progress has been made; store where work should start
            pdone = 1 - (taskprogress.Get("blocksize") / My.Settings.blocksize)
        End If

    End Sub
    Public Sub Control_Loop()
        Dim responseHTML As String
        Dim holdstring As String

        If Upload_Needed() And Contact_OK() Then
            'try the upload
            upload_work()
            Return
        End If

        If Is_Running() And Checked_In Then
            If Work_Finished Then
                upload_work()
                neurontouched = Now()
                Return
            End If

            If nrniv.HasExited Then
                Current_Task() = "NEURON EXITED"
                My.Settings.neuronerrors = Val(My.Settings.neuronerrors) + 1
                My.Settings.Save()
                If Val(My.Settings.neuronerrors) > 3 Then
                    skipwork()
                End If
                neuron_prepare()
                Neuron_Start()
                Current_Task = "NEURON RECOVERED"
            End If

            If Val(My.Settings.neurontimeout) > 0 Then
                gettouch()
                If DateDiff(DateInterval.Second, Neuron_Touched(), Now()) > (Val(My.Settings.neurontimeout) * 60) Then
                    Current_Task() = "NEURON TIMED OUT"
                    My.Settings.neuronerrors = Val(My.Settings.neuronerrors) + 1
                    My.Settings.Save()
                    If Val(My.Settings.neuronerrors) > 3 Then
                        skipwork()
                    End If
                    Neuron_Kill()
                    neuron_prepare()
                    Neuron_Start()
                    Current_Task = "NEURON RECOVERED"
                End If
            End If
        End If


        If Error_Flag And Contact_OK() Then
            'MsgBox(Error_Message())
            'Error_Message() = ""
        End If

        If Not Checked_In() And Contact_OK() Then
            'check in
            Current_Task() = "Checking in with server"
            Dim cparams As System.Collections.Specialized.NameValueCollection = CheckIn_Params()
            responseHTML = GetPageHTML(My.Settings.Server & "/client/client_checkin.php" & Query_String(cparams), 20)

            Dim nsweepmessage As System.Collections.Specialized.NameValueCollection = ReadNsweepMessage(responseHTML)
            If Not nsweepmessage.HasKeys Then
                Server_Messages() = responseHTML
                Error_Message() = "server response not understood: " & responseHTML
                nextcontactdate = DateAdd(DateInterval.Minute, 15, Now())
                Current_Task() = "Waiting for good server response"
                Return
            End If

            If Not nsweepmessage.Get("pause") = Nothing Then
                nextcontactdate = DateAdd(DateInterval.Second, Val(nsweepmessage.Get("pause")), Now())
                Current_Task() = "Waiting for published model"
            End If

            If Not nsweepmessage.Get("nowork") = Nothing Then
                Server_Messages() = nsweepmessage.Get("nowork")
                Current_Task() = "Checking in server to have work"
                Return
            End If

            If Not nsweepmessage.Get("command") = Nothing Then
                Server_Messages() = nsweepmessage.Get("command")
                Select Case nsweepmessage.Get("command")
                    Case Is = "setmodel"
                        If Is_Running Then nrniv.Kill()
                        holdstring = Model_Checkout(nsweepmessage.Get("model"), cparams)
                        If holdstring <> "success" Then
                            Error_Message() = holdstring
                        Else
                            neuron_prepare()
                        End If
                        Return
                    Case Is = "dropwork"
                        Current_Task() = "dropping work"
                        clearwork()
                        checkedin = False
                        Return
                    Case Is = "setwork"
                        Current_Task() = "setting work"
                        My.Settings.workstart = nsweepmessage.Get("workstart")
                        My.Settings.blocksize = nsweepmessage.Get("blocksize")
                        My.Settings.clientid = nsweepmessage.Get("clientid")
                        My.Settings.Save()
                End Select
            End If
            Current_Task() = "Checked in: Starting work"
            checkedin = True
            neuron_prepare()
            If checkedin = True Then
                Current_Task() = "starting neuron"
                If Not Is_Running Then Neuron_Start()
            End If
        End If

    End Sub

    Public Function Model_Checkout(ByVal model As String, ByVal cparams As System.Collections.Specialized.NameValueCollection) As String
        Current_Task() = "Model Checkout: Starting"
        'this function downloads a model from the nsweep server
        If cparams.Get("model") = Nothing Then
            cparams.Add("model", model)
        Else
            cparams("model") = model
        End If

        'contact the server and parse out its message
        Dim contactnsweep As String = GetPageHTML(My.Settings.Server & "/client/model_checkout.php" & Query_String(cparams), 20)

        Current_Task() = "Parsing model directory listing"
        Dim nsweepmessage As System.Collections.Specialized.NameValueCollection = ReadNsweepMessage(contactnsweep)

        If Not nsweepmessage.HasKeys Then
            'no messages contained in server response
            Server_Messages() = contactnsweep
            nextcontactdate = DateAdd(DateInterval.Minute, 15, Now())
            Return "server error: " & contactnsweep
        End If

        If nsweepmessage.Get("command") <> "success" Then
            If Not nsweepmessage.Get("pause") = Nothing Then
                nextcontactdate = DateAdd(DateInterval.Second, Val(nsweepmessage.Get("pause")), Now())
            End If
            If Not nsweepmessage.Get("nowork") = Nothing Then
                Server_Messages() = nsweepmessage.Get("nowork")
            End If
            Return "server error: couldn't get model directory listing" & contactnsweep
        End If

        'clear any prior models
        Dim modeldir As System.IO.DirectoryInfo
        modeldir = New System.IO.DirectoryInfo(My.Settings.NSweepDir & "\models")
        If modeldir.Exists Then
            Try
                My.Computer.FileSystem.DeleteDirectory(modeldir.FullName, FileIO.DeleteDirectoryOption.DeleteAllContents)
            Catch prob As Exception
                Return "can't delete model directory: " & prob.Message
            End Try
        End If
        modeldir = Nothing

        'remake the model directory
        Try
            MkDir(My.Settings.NSweepDir & "\models")
            MkDir(My.Settings.NSweepDir & "\models\" & model)
            MkDir(My.Settings.NSweepDir & "\models\" & model & "\work")
            MkDir(My.Settings.NSweepDir & "\models\" & model & "\reports")
            MkDir(My.Settings.NSweepDir & "\models\" & model & "\simfiles")
        Catch ex As Exception
            Return "can't make model directory: " & ex.Message
        End Try

        'create the directory structure
        For Each key As String In nsweepmessage
            If nsweepmessage.Get(key) = "dir" And InStr(key, "/CVS/") = 0 Then
                Try
                    MkDir(My.Settings.NSweepDir & key)
                Catch prob As Exception
                    Return "cant make model directory" & prob.Message
                End Try
            End If
        Next

        'now download each file
        For Each key As String In nsweepmessage
            If nsweepmessage.Get(key) = "file" And InStr(key, "/CVS/") = 0 Then
                Try
                    'Current_Task() = "Download " & key
                    My.Computer.Network.DownloadFile(My.Settings.Server & key, My.Settings.NSweepDir & key)
                Catch ex As Exception
                    Return "couldn't download : " & ex.Message
                End Try
            End If
        Next

        My.Settings.modeldir = model
        My.Settings.modelversion = Val(nsweepmessage.Get("modelversion"))
        My.Settings.modelstart = nsweepmessage.Get("modelstart")
        My.Settings.modelparams = nsweepmessage.Get("modelparams")
        My.Settings.inlinereport = nsweepmessage.Get("inlinereport")
        My.Settings.Save()
        Current_Task() = "Model Checkout: Got " & model
        Return "success"
    End Function

    Public Function Work_Progress(ByVal workstart As Integer, ByVal blocksize As Integer) As System.Collections.Specialized.NameValueCollection
        'this function determines how much work has been accomplished on a particular work block
        'you pass the workstart and block size
        'it reads the summary file for the workstart and returns a keyed array with what would be the next workstart and blocksize
        'if it determines that the workblock is complete, it sets the upload flag

        Dim progress As New System.Collections.Specialized.NameValueCollection

        If My.Settings.modeldir < " " Then Return progress

        Dim completed As New System.IO.FileInfo(modeldirectory & "\reports\" & workstart & ".txt")
        If Not completed.Exists Then
            completed = Nothing
            Return progress
        End If

        Dim workcompleted As String
        Dim columns() As String
        Dim nextstart As Integer = 0
        Dim completedfile As System.IO.StreamReader
        Try
            completedfile = New System.IO.StreamReader(New System.IO.FileStream(completed.FullName, IO.FileMode.Open))
            While Not completedfile.EndOfStream
                workcompleted = completedfile.ReadLine
                columns = Split(workcompleted, ", ")
                If (columns(0) = My.Settings.modeldir) Then
                    If (columns(3) > nextstart) And (columns(3) < (workstart + blocksize)) Then nextstart = columns(3)
                End If
            End While
            completedfile.Close()
            completedfile = Nothing
            completed = Nothing
        Catch ex As Exception
            Error_Message() = "Problem reading work progress: " & ex.Message
            completed = Nothing
        End Try

        If nextstart = 0 Then Return progress
        nextstart = nextstart + 1

        If nextstart = workstart + blocksize Then
            uploadneeded = True
            Return progress
        End If

        progress.Add("workstart", nextstart)
        progress.Add("blocksize", blocksize - (nextstart - workstart))
        Return progress

    End Function

    Public Sub Check_Out()

        Dim responseHTML As String
        Current_Task() = "checkout from server"

        'if running then shutdown neuron
        If Is_Running() Then
            Neuron_Kill()
            If Not Checked_In Then Return

            'if neuron had been running - save its progress
            Dim taskprogress As System.Collections.Specialized.NameValueCollection = Work_Progress(Val(My.Settings.workstart), Val(My.Settings.blocksize))
            If taskprogress.HasKeys Then
                Work_Write("block", taskprogress.Get("workstart"), taskprogress.Get("blocksize"), My.Settings.workstart)
                pdone = 1 - (taskprogress.Get("blocksize") / My.Settings.blocksize)
            End If
        End If

        If Not Checked_In Then Return

        'now check out
        Dim cparams As System.Collections.Specialized.NameValueCollection = CheckIn_Params()
        responseHTML = GetPageHTML(My.Settings.Server & "/client/client_checkout.php" & Query_String(cparams), 20)

        Dim nsweepmessage As System.Collections.Specialized.NameValueCollection = ReadNsweepMessage(responseHTML)
        If Not nsweepmessage.HasKeys Then
            Server_Messages() = responseHTML
            Error_Message() = "checkout not aknowledged: " & responseHTML
            nextcontactdate = DateAdd(DateInterval.Minute, 15, Now())
            Return
        End If

        Server_Messages() = "checked out; time on =" & nsweepmessage.Get("timeon")
        checkedin = False

    End Sub

    Public Sub Work_Write(ByVal type As String, ByVal workstart As Integer, ByVal blocksize As Integer, ByVal workname As Integer)
        Try
            Dim workfile As New System.IO.StreamWriter(New System.IO.FileStream(modeldirectory & "\work\work.txt", IO.FileMode.Create))
            workfile.WriteLine(type & " " & workstart & "   " & blocksize & "   " & workname)
            workfile.Flush()
            workfile.Close()
            workfile = Nothing
        Catch ex As Exception
            If Not Is_Running Then nrniv.Kill()
            checkedin = False
            clearwork()
            Error_Message() = "Can't create workfile: " & ex.Message
        End Try
    End Sub

    Public Function Work_Read() As System.Collections.Specialized.NameValueCollection
        Dim work As New System.Collections.Specialized.NameValueCollection
        Dim workline As String = ""
        Try
            Dim workfile As New System.IO.StreamReader(New System.IO.FileStream(modeldirectory & "\work\work.txt", IO.FileMode.Open))
            If workfile.EndOfStream Then Return work
            workline = workfile.ReadLine
            workfile.Close()
            workfile = Nothing
        Catch ex As Exception
            Error_Message() = "Can't read workfile: " & ex.Message
        End Try

        While InStr(workline, "  ")
            workline = Replace(workline, "  ", " ")
        End While
        If workline < " " Then Return work

        Dim columns() As String = Split(workline, " ")
        work.Add("workstart", columns(1))
        work.Add("blocksize", columns(2))

        Return work
    End Function

    Public Function CheckIn_Params() As System.Collections.Specialized.NameValueCollection
        Dim params As New System.Collections.Specialized.NameValueCollection
        params.Add("host", My.Computer.Name)
        params.Add("clientversion", My.Settings.clientversion)
        params.Add("password", My.Settings.password)

        If My.Settings.modeldir <> "" Then params.Add("model", My.Settings.modeldir)
        If My.Settings.modelversion <> "" Then params.Add("modelversion", My.Settings.modelversion)
        If Val(My.Settings.blocksize) > 0 Then
            params.Add("workstart", My.Settings.workstart)
            params.Add("blocksize", My.Settings.blocksize)
            params.Add("pdone", Int(p_done() * 100))
        End If
        params.Add("inlinereport", My.Settings.inlinereport)
        Return params
    End Function

    Public Sub neuron_prepare()
        Current_Task() = "Neuron - preparing"

        If Trim(My.Settings.modeldir) = "" Or My.Settings.modeldir = Nothing Then
            checkedin = False
            clearmodel()
            Return
        End If

        modeldirectory = My.Settings.NSweepDir & "\models\" & My.Settings.modeldir

        If Trim(My.Settings.modelstart) = "" Or My.Settings.modelstart = Nothing Then
            Error_Message() = "model start file not defined"
            checkedin = False
            clearmodel()
            Return
        End If

        
        Dim modelstart As New System.IO.FileInfo(modeldirectory & "\simfiles\" & My.Settings.modelstart)
        If Not modelstart.Exists Then
            Error_Message() = "Model start doesn't exist"
            checkedin = False
            clearmodel()
            Return
        End If


        If Val(My.Settings.blocksize) < 0 Then
            checkedin = False
            clearwork()
            Return
        End If

        If Not writestart() Then
            checkedin = False
            clearwork()
            Error_Message() = "Can't create start.hoc"
            Return
        End If

        'we have a model, so define its directory and finished file
        finishedfile = New System.IO.FileInfo(modeldirectory & "\work\finished.txt")

        Dim taskprogress As System.Collections.Specialized.NameValueCollection = Work_Progress(Val(My.Settings.workstart), Val(My.Settings.blocksize))
        If taskprogress.HasKeys Then
            'yes, progress has been made; store where work should start
            pdone = 1 - (taskprogress.Get("blocksize") / My.Settings.blocksize)
        Else
            'no, progress has not registered; work should start at beginning of assignment
            taskprogress.Add("workstart", My.Settings.workstart)
            taskprogress.Add("blocksize", My.Settings.blocksize)
            pdone = 0
        End If

        Current_Task() = "creating workfile"
        Work_Write("block", Val(taskprogress.Get("workstart")), Val(taskprogress.Get("blocksize")), Val(My.Settings.workstart))

        'now that work has been set up, make sure finished is not flagged
        If finishedfile.Exists Then finishedfile.Delete()

    End Sub

    Public Sub resetwait()
        nextcontactdate = Now()
    End Sub

    Public Sub resetcheckedin()
        checkedin = False
    End Sub

    Private Sub clearmodel()
        My.Settings.modeldir = ""
        My.Settings.modelversion = ""
        My.Settings.modelparams = 0
        My.Settings.modelstart = ""
        My.Settings.workstart = 0
        My.Settings.blocksize = -1
        My.Settings.neuronerrors = 0
        My.Settings.Save()
    End Sub

    Private Sub clearwork()
        My.Settings.blocksize = -1
        My.Settings.workstart = 0
        My.Settings.neuronerrors = 0
        My.Settings.Save()
    End Sub


    Public Function writestart() As Boolean
        Try
            Dim startfile As New System.IO.StreamWriter(New System.IO.FileStream(modeldirectory & "\start.hoc", IO.FileMode.Create))
            startfile.WriteLine("/* system variables */")
            startfile.WriteLine("strdef paramdeffile")
            startfile.WriteLine("worktimeout = 5")
            startfile.WriteLine(magicquotes("paramdeffile = 'params.hoc'"))
            startfile.WriteLine()
            startfile.WriteLine("/* client variables */")
            startfile.WriteLine("strdef winsweepdirectory, clientid")
            startfile.WriteLine(magicquotes("winsweepdirectory = '" & Replace(My.Settings.NSweepDir, "\", "/") & "'"))
            startfile.WriteLine(magicquotes("clientid = '" & My.Settings.clientid & "'"))
            startfile.WriteLine()
            startfile.WriteLine("/* variables for this sweep */")
            startfile.WriteLine("strdef simdirectory, simfile")
            startfile.WriteLine(magicquotes("simdirectory = '" & My.Settings.modeldir & "'"))
            startfile.WriteLine(magicquotes("simfile = '" & My.Settings.modelstart & "'"))
            startfile.WriteLine()
            startfile.WriteLine("/* load sweep controls and run */")
            startfile.WriteLine("chdir(winsweepdirectory)")
            startfile.WriteLine(magicquotes("load_file('sweep.hoc')"))
            startfile.Flush()
            startfile.Close()
            startfile = Nothing
            Return True
        Catch ex As Exception
            
            Return False
        End Try
    End Function

    Public Function magicquotes(ByVal input As String) As String
        Return Replace(input, "'", Chr(34))
    End Function

    Public Sub Neuron_Start()
        Current_Task() = "Neuron - Starting"
        nrniv = New Process
        neurontouched = Now()
        nrniv.StartInfo.FileName = My.Settings.NrnivDir & "\bin\" & My.Settings.NrnivCmd
        nrniv.StartInfo.WorkingDirectory = My.Settings.NrnivDir
        nrniv.StartInfo.Arguments = My.Settings.NSweepDir & "\models\" & My.Settings.modeldir & "\start.hoc"
        nrniv.Start()
        isrunning = True

    End Sub

    Public Sub Neuron_Kill()
        Current_Task() = "Neuron - Killing"
        If Not nrniv.HasExited Then nrniv.Kill()

        nrniv = Nothing
        isrunning = False
    End Sub
    Public Sub upload_file(ByVal filename As String, ByVal cparams As System.Collections.Specialized.NameValueCollection)

        Dim f As System.IO.FileInfo
        f = New System.IO.FileInfo(filename)
        Dim nsweepmessage As System.Collections.Specialized.NameValueCollection
        Dim contactnsweep As String

        If Not f.Exists Then Return

        'cparams = CheckIn_Params()
        contactnsweep = UploadFile(f.FullName, My.Settings.Server & "/client/client_upload.php", "workfile", "", cparams, 120)
        nsweepmessage = ReadNsweepMessage(contactnsweep)

        If Not nsweepmessage.HasKeys Then
            'no messages contained in server response
            Server_Messages() = contactnsweep
            nextcontactdate = DateAdd(DateInterval.Minute, 15, Now())
            uploadneeded = True
            Return
        End If

        If Not nsweepmessage("fail") = Nothing Then
            If nsweepmessage.Get("fail") = "exists" Then GoTo noupload
            Server_Messages() = contactnsweep
            My.Settings.uploadattempts = Val(My.Settings.uploadattempts) + 1
            My.Settings.Save()
            nextcontactdate = DateAdd(DateInterval.Minute, 10, Now())
            uploadneeded = True
            Return
        End If

noupload:
        Try
            f.IsReadOnly = False
            f.Delete()
        Catch ex As Exception
            Error_Message() = "couldn't delete uploaded file: " & ex.Message
        End Try
        f = Nothing
        Return
    End Sub
    Public Sub upload_work()
        If Val(My.Settings.uploadattempts) > 10 Then
            clearwork()
            checkedin = False
            uploadneeded = False
            Return
        End If

        Current_Task = "Uploading Work - started"
        Dim cparams As System.Collections.Specialized.NameValueCollection = CheckIn_Params()

        uploadneeded = False
        upload_file(modeldirectory & "\reports\" & My.Settings.workstart & ".txt", cparams)
        If Val(My.Settings.inlinereport) > 0 Then
            upload_file(modeldirectory & "\reports\in" & My.Settings.workstart & ".txt", cparams)
        End If

        If uploadneeded Then Return

        'if successful
        uploadneeded = False
        clearwork()
        My.Settings.uploadattempts = ""
        My.Settings.neuronerrors = 0
        My.Settings.Save()
        checkedin = False
        Current_Task() = "Uploading work - succeeded"

    End Sub

    Protected Overrides Sub Finalize()
        MyBase.Finalize()
    End Sub

    Private Sub gettouch()
        Dim nwork As New System.IO.FileInfo(modeldirectory & "\reports\" & My.Settings.workstart & ".txt")
        If Not nwork.Exists Then
            nwork = Nothing
            Return
        End If
        If nwork.LastWriteTime > neurontouched Then neurontouched = nwork.LastWriteTime

    End Sub

    Public Sub skipwork()
        Current_Task() = "Neuron - Skipping work"
        Dim taskprogress As System.Collections.Specialized.NameValueCollection = Work_Progress(Val(My.Settings.workstart), Val(My.Settings.blocksize))
        If taskprogress.HasKeys Then
            'yes, progress has been made; store where work should start
            pdone = 1 - (taskprogress.Get("blocksize") / My.Settings.blocksize)
        Else
            'no, progress has not registered; work should start at beginning of assignment
            taskprogress.Add("workstart", My.Settings.workstart)
            taskprogress.Add("blocksize", My.Settings.blocksize)
            pdone = 0
        End If


        Dim completed As New System.IO.StreamWriter(New System.IO.FileStream(modeldirectory & "\reports\" & My.Settings.workstart & ".txt", IO.FileMode.Append))
        completed.WriteLine(My.Settings.modeldir & ", params.hoc, " & My.Settings.clientid & ", " & (Val(taskprogress.Get("workstart"))) & ", 0")
        completed.Flush()
        completed.Close()
        My.Settings.neuronerrors = 0
        My.Settings.Save()

    End Sub
End Class
