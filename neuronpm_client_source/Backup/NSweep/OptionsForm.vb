
'''<summary>
''' Screen responsible for reading and writing common user settings.  
''' </summary>
Public Class OptionsForm
    Public neuron As nrniv
    Public neuronon As Boolean


    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        neuron = New nrniv
        neuronon = True
    End Sub

    Private Sub OptionsForm_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        neuronon = False
        loadsettings()
    End Sub

    Private Sub Save_Settings_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Save_Settings.Click
        My.Settings.NrnivCmd = Me.NrnivCmd.Text
        My.Settings.NrnivDir = Me.NrnivDir.Text
        My.Settings.NSweepDir = Me.NSweepDir.Text
        My.Settings.Server = Me.Server.Text
        My.Settings.password = Me.password.Text
        My.Settings.modeldir = Me.modeldir.Text
        My.Settings.workstart = Me.workstart.Text
        My.Settings.blocksize = Me.blocksize.Text
        My.Settings.modelversion = Me.modelversion.Text
        My.Settings.inlinereport = Me.InLineReport.Text
        My.Settings.runsafe = Me.runsafe.Text
        My.Settings.neurontimeout = Me.neurontimeout.Text
        My.Settings.Save()
    End Sub

    Private Sub Button2_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button2.Click
        If neuronon Then
            neuron.resetwait()
        End If
    End Sub

  
    Private Sub loadsettings()
        Me.NrnivCmd.Text = My.Settings.NrnivCmd
        Me.NrnivDir.Text = My.Settings.NrnivDir
        Me.NSweepDir.Text = My.Settings.NSweepDir
        Me.Server.Text = My.Settings.Server
        Me.password.Text = My.Settings.password
        Me.modeldir.Text = My.Settings.modeldir
        Me.workstart.Text = My.Settings.workstart
        Me.blocksize.Text = My.Settings.blocksize
        Me.modelversion.Text = My.Settings.modelversion
        Me.modelparams.Text = My.Settings.modelparams
        Me.modelstart.Text = My.Settings.modelstart
        Me.clientid.Text = My.Settings.clientid
        Me.InLineReport.Text = My.Settings.inlinereport
        Me.runsafe.Text = My.Settings.runsafe
        Me.neurontimeout.Text = My.Settings.neurontimeout
        Me.timeouts.Text = My.Settings.neuronerrors
    End Sub

    Private Sub Button3_Click(ByVal sender As System.Object, ByVal e As System.EventArgs)
        If neuronon Then
            neuron.upload_work()
            loadsettings()
        End If
    End Sub

    Private Sub Button4_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button4.Click
        If neuronon Then
            neuron.Check_Out()
            neuronon = False
        End If
    End Sub


    Private Sub Timer1_Tick(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Timer1.Tick

        If neuronon = True Then
            neuron.Control_Loop()
            If neuron.Error_Flag Then Me.errorlog.Text = neuron.Error_Message & Me.errorlog.Text
            Me.currenttask.Text = neuron.Current_Task & Me.currenttask.Text
            Me.servermessages.Text = neuron.Server_Messages & Me.servermessages.Text
            Me.waittill.Text = DateDiff(DateInterval.Second, Now(), neuron.Next_Contact_Date)
            Me.checkedin.Text = neuron.Checked_In
            Me.neuronstatus.Text = neuron.Is_Running
            Me.Pdone.Text = neuron.p_done
            loadsettings()
            Me.neurontouched.Text = DateDiff(DateInterval.Second, neuron.Neuron_Touched, Now())
        Else
            Me.waittill.Text = Now()

        End If
    End Sub

    Private Sub OptionsForm_FormClosed(ByVal sender As System.Object, ByVal e As System.Windows.Forms.FormClosedEventArgs) Handles MyBase.FormClosed
        If neuronon Then neuron.Check_Out()
    End Sub



    Private Sub TestConn_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles TestConn.Click

        Dim cparams As New System.Collections.Specialized.NameValueCollection

        cparams.Add("host", My.Computer.Name)
        cparams.Add("clientversion", My.Settings.clientversion)
        cparams.Add("password", My.Settings.password)

        If My.Settings.modeldir <> "" Then cparams.Add("model", My.Settings.modeldir)
        If My.Settings.modelversion <> "" Then cparams.Add("modelversion", My.Settings.modelversion)
        If Val(My.Settings.blocksize) > 0 Then
            cparams.Add("workstart", My.Settings.workstart)
            cparams.Add("blocksize", My.Settings.blocksize)
        End If
        cparams.Add("inlinereport", My.Settings.inlinereport)
        
        Dim requesturl As String = My.Settings.Server & "/client/client_test.php" & Query_String(cparams)
        Dim replymsg As String
        Dim responseHTML As String = GetPageHTML(requesturl, 20)


        Dim nsweepmessage As System.Collections.Specialized.NameValueCollection = ReadNsweepMessage(responseHTML)
        If Not nsweepmessage.HasKeys Then
            MsgBox("No response received from request to " & My.Settings.Server & "/client/client_test.php" & Query_String(cparams))
            Return
        Else
            replymsg = "Success!! Server messages are: "
            For Each k As String In nsweepmessage.Keys
                replymsg = replymsg & " " & k & "=" & nsweepmessage.Get(k)
            Next
            MsgBox(replymsg)
        End If

    End Sub

    Private Sub Reset_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Reset.Click
        If neuronon = False Then
            My.Settings.Reset()
            loadsettings()

        End If
    End Sub
End Class