Namespace My

    'The following events are available for MyApplication
    '
    'Startup: Raised when the application starts, before the startup form is created.
    'Shutdown: Raised after all application forms are closed.  This event is not raised if the application is terminating abnormally.
    'UnhandledException: Raised if the application encounters an unhandled exception.
    'StartupNextInstance: Raised when launching a single-instance application and the application is already active. 
    'NetworkAvailabilityChanged: Raised when the network connection is connected or disconnected.

    Class MyApplication

        Private Sub MyApplication_Startup(ByVal sender As Object, ByVal e As ApplicationServices.StartupEventArgs) Handles Me.Startup
            ' My.Settings.runsafe = "1"
            ' My.Settings.Save()

            If Trim(My.Settings.NSweepDir) = "" Then
                MsgBox("NeuronPM Directory not set")
                Me.MainForm = My.Forms.OptionsForm
                Return
            End If

            Dim mydir As New System.IO.DirectoryInfo(My.Settings.NSweepDir)
            Try
                If Not mydir.Exists Then mydir.Create()
                mydir = Nothing
            Catch ex As Exception
                MsgBox("Can't find/create neuronpm directory")
                Me.MainForm = My.Forms.OptionsForm
                mydir = Nothing
                Return
            End Try

            Dim hocfiles As System.IO.StreamWriter
            Try
                hocfiles = New System.IO.StreamWriter(My.Settings.NSweepDir & "\sweep.hoc", False)
                hocfiles.Write(My.Resources.sweep.ToString)
                hocfiles.Flush()
                hocfiles.Close()
                hocfiles = New System.IO.StreamWriter(My.Settings.NSweepDir & "\sweeptypes.hoc", False)
                hocfiles.Write(My.Resources.sweeptypes.ToString)
                hocfiles.Flush()
                hocfiles.Close()
                hocfiles = Nothing
            Catch ex As Exception
                MsgBox("Can't make neuronpm hoc files")
                Me.MainForm = My.Forms.OptionsForm
                hocfiles = Nothing
                Return
            End Try

            If e.CommandLine.Count Then
                Dim arg As String = e.CommandLine(0).ToLower(System.Globalization.CultureInfo.InvariantCulture)

                If InStr(arg, "/c") > 0 Then
                    Me.MainForm = My.Forms.OptionsForm
                    Return
                End If

                If InStr(arg, "/p") > 0 Then
                    Me.MainForm = My.Forms.preview
                    Return
                End If
            End If
            If My.Settings.runsafe = "1" Or My.Settings.runsafe = 1 Then
                Me.MainForm = My.Forms.OptionsForm
            Else
                Me.MainForm = My.Forms.ScreenSaverForm
            End If
        End Sub

    End Class
End Namespace
