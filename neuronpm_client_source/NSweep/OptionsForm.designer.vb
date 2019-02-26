<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class OptionsForm
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing AndAlso components IsNot Nothing Then
            components.Dispose()
        End If
        MyBase.Dispose(disposing)
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.components = New System.ComponentModel.Container
        Me.Button1 = New System.Windows.Forms.Button
        Me.currenttask = New System.Windows.Forms.TextBox
        Me.servermessages = New System.Windows.Forms.TextBox
        Me.errorlog = New System.Windows.Forms.TextBox
        Me.NrnivDir = New System.Windows.Forms.TextBox
        Me.NrnivCmd = New System.Windows.Forms.TextBox
        Me.NSweepDir = New System.Windows.Forms.TextBox
        Me.Server = New System.Windows.Forms.TextBox
        Me.password = New System.Windows.Forms.TextBox
        Me.modeldir = New System.Windows.Forms.TextBox
        Me.workstart = New System.Windows.Forms.TextBox
        Me.blocksize = New System.Windows.Forms.TextBox
        Me.modelversion = New System.Windows.Forms.TextBox
        Me.Label1 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.Label3 = New System.Windows.Forms.Label
        Me.Label4 = New System.Windows.Forms.Label
        Me.Label5 = New System.Windows.Forms.Label
        Me.Label6 = New System.Windows.Forms.Label
        Me.Label7 = New System.Windows.Forms.Label
        Me.Label8 = New System.Windows.Forms.Label
        Me.Label9 = New System.Windows.Forms.Label
        Me.Save_Settings = New System.Windows.Forms.Button
        Me.waittill = New System.Windows.Forms.TextBox
        Me.Button2 = New System.Windows.Forms.Button
        Me.Button4 = New System.Windows.Forms.Button
        Me.Label10 = New System.Windows.Forms.Label
        Me.modelstart = New System.Windows.Forms.TextBox
        Me.Label11 = New System.Windows.Forms.Label
        Me.modelparams = New System.Windows.Forms.TextBox
        Me.Label12 = New System.Windows.Forms.Label
        Me.clientid = New System.Windows.Forms.TextBox
        Me.Label13 = New System.Windows.Forms.Label
        Me.InLineReport = New System.Windows.Forms.TextBox
        Me.Timer1 = New System.Windows.Forms.Timer(Me.components)
        Me.Label14 = New System.Windows.Forms.Label
        Me.Label15 = New System.Windows.Forms.Label
        Me.Label16 = New System.Windows.Forms.Label
        Me.Label17 = New System.Windows.Forms.Label
        Me.Label18 = New System.Windows.Forms.Label
        Me.runsafe = New System.Windows.Forms.TextBox
        Me.Label19 = New System.Windows.Forms.Label
        Me.checkedin = New System.Windows.Forms.TextBox
        Me.Label20 = New System.Windows.Forms.Label
        Me.neuronstatus = New System.Windows.Forms.TextBox
        Me.Label21 = New System.Windows.Forms.Label
        Me.neurontouched = New System.Windows.Forms.TextBox
        Me.Label22 = New System.Windows.Forms.Label
        Me.neurontimeout = New System.Windows.Forms.TextBox
        Me.Label23 = New System.Windows.Forms.Label
        Me.Pdone = New System.Windows.Forms.TextBox
        Me.Label24 = New System.Windows.Forms.Label
        Me.timeouts = New System.Windows.Forms.TextBox
        Me.Label25 = New System.Windows.Forms.Label
        Me.TestConn = New System.Windows.Forms.Button
        Me.Reset = New System.Windows.Forms.Button
        Me.SuspendLayout()
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(22, 504)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(75, 23)
        Me.Button1.TabIndex = 0
        Me.Button1.Text = "startwork"
        '
        'currenttask
        '
        Me.currenttask.Location = New System.Drawing.Point(4, 360)
        Me.currenttask.Multiline = True
        Me.currenttask.Name = "currenttask"
        Me.currenttask.Size = New System.Drawing.Size(239, 92)
        Me.currenttask.TabIndex = 1
        '
        'servermessages
        '
        Me.servermessages.Location = New System.Drawing.Point(249, 360)
        Me.servermessages.Multiline = True
        Me.servermessages.Name = "servermessages"
        Me.servermessages.Size = New System.Drawing.Size(192, 92)
        Me.servermessages.TabIndex = 2
        '
        'errorlog
        '
        Me.errorlog.Location = New System.Drawing.Point(447, 360)
        Me.errorlog.Multiline = True
        Me.errorlog.Name = "errorlog"
        Me.errorlog.Size = New System.Drawing.Size(192, 92)
        Me.errorlog.TabIndex = 3
        '
        'NrnivDir
        '
        Me.NrnivDir.Location = New System.Drawing.Point(114, 10)
        Me.NrnivDir.Name = "NrnivDir"
        Me.NrnivDir.Size = New System.Drawing.Size(197, 20)
        Me.NrnivDir.TabIndex = 4
        '
        'NrnivCmd
        '
        Me.NrnivCmd.Location = New System.Drawing.Point(114, 36)
        Me.NrnivCmd.Name = "NrnivCmd"
        Me.NrnivCmd.Size = New System.Drawing.Size(197, 20)
        Me.NrnivCmd.TabIndex = 5
        '
        'NSweepDir
        '
        Me.NSweepDir.Location = New System.Drawing.Point(130, 62)
        Me.NSweepDir.Name = "NSweepDir"
        Me.NSweepDir.Size = New System.Drawing.Size(181, 20)
        Me.NSweepDir.TabIndex = 6
        '
        'Server
        '
        Me.Server.Location = New System.Drawing.Point(434, 10)
        Me.Server.Name = "Server"
        Me.Server.Size = New System.Drawing.Size(197, 20)
        Me.Server.TabIndex = 7
        '
        'password
        '
        Me.password.Location = New System.Drawing.Point(434, 36)
        Me.password.Name = "password"
        Me.password.Size = New System.Drawing.Size(197, 20)
        Me.password.TabIndex = 8
        '
        'modeldir
        '
        Me.modeldir.Location = New System.Drawing.Point(114, 179)
        Me.modeldir.Name = "modeldir"
        Me.modeldir.Size = New System.Drawing.Size(197, 20)
        Me.modeldir.TabIndex = 9
        '
        'workstart
        '
        Me.workstart.Location = New System.Drawing.Point(434, 176)
        Me.workstart.Name = "workstart"
        Me.workstart.Size = New System.Drawing.Size(197, 20)
        Me.workstart.TabIndex = 10
        '
        'blocksize
        '
        Me.blocksize.Location = New System.Drawing.Point(434, 202)
        Me.blocksize.Name = "blocksize"
        Me.blocksize.Size = New System.Drawing.Size(197, 20)
        Me.blocksize.TabIndex = 11
        '
        'modelversion
        '
        Me.modelversion.Location = New System.Drawing.Point(114, 153)
        Me.modelversion.Name = "modelversion"
        Me.modelversion.Size = New System.Drawing.Size(197, 20)
        Me.modelversion.TabIndex = 12
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(3, 17)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(99, 13)
        Me.Label1.TabIndex = 13
        Me.Label1.Text = "Neuron Directory"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(3, 43)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(102, 13)
        Me.Label2.TabIndex = 14
        Me.Label2.Text = "Neuron Command"
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(3, 69)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(117, 13)
        Me.Label3.TabIndex = 15
        Me.Label3.Text = "NeuronPM Directory"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(323, 17)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(40, 13)
        Me.Label4.TabIndex = 16
        Me.Label4.Text = "Server"
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(323, 43)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(93, 13)
        Me.Label5.TabIndex = 17
        Me.Label5.Text = "Client Password"
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Location = New System.Drawing.Point(19, 186)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(32, 13)
        Me.Label6.TabIndex = 18
        Me.Label6.Text = "Model"
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(339, 183)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(49, 13)
        Me.Label7.TabIndex = 19
        Me.Label7.Text = "Workstart"
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(339, 209)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(48, 13)
        Me.Label8.TabIndex = 20
        Me.Label8.Text = "Blocksize"
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(19, 160)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(67, 13)
        Me.Label9.TabIndex = 21
        Me.Label9.Text = "ModelVersion"
        '
        'Save_Settings
        '
        Me.Save_Settings.Location = New System.Drawing.Point(564, 88)
        Me.Save_Settings.Name = "Save_Settings"
        Me.Save_Settings.Size = New System.Drawing.Size(67, 23)
        Me.Save_Settings.TabIndex = 22
        Me.Save_Settings.Text = "Save Settings"
        '
        'waittill
        '
        Me.waittill.Location = New System.Drawing.Point(311, 458)
        Me.waittill.Name = "waittill"
        Me.waittill.Size = New System.Drawing.Size(188, 20)
        Me.waittill.TabIndex = 23
        '
        'Button2
        '
        Me.Button2.Location = New System.Drawing.Point(114, 504)
        Me.Button2.Name = "Button2"
        Me.Button2.Size = New System.Drawing.Size(75, 23)
        Me.Button2.TabIndex = 24
        Me.Button2.Text = "resetwait"
        '
        'Button4
        '
        Me.Button4.Location = New System.Drawing.Point(217, 504)
        Me.Button4.Name = "Button4"
        Me.Button4.Size = New System.Drawing.Size(75, 23)
        Me.Button4.TabIndex = 26
        Me.Button4.Text = "stopwork"
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(19, 215)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(52, 13)
        Me.Label10.TabIndex = 28
        Me.Label10.Text = "Modelstart"
        '
        'modelstart
        '
        Me.modelstart.Location = New System.Drawing.Point(114, 208)
        Me.modelstart.Name = "modelstart"
        Me.modelstart.Size = New System.Drawing.Size(197, 20)
        Me.modelstart.TabIndex = 27
        '
        'Label11
        '
        Me.Label11.AutoSize = True
        Me.Label11.Location = New System.Drawing.Point(339, 157)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(66, 13)
        Me.Label11.TabIndex = 30
        Me.Label11.Text = "Modelparams"
        '
        'modelparams
        '
        Me.modelparams.Location = New System.Drawing.Point(434, 150)
        Me.modelparams.Name = "modelparams"
        Me.modelparams.Size = New System.Drawing.Size(197, 20)
        Me.modelparams.TabIndex = 29
        '
        'Label12
        '
        Me.Label12.AutoSize = True
        Me.Label12.Location = New System.Drawing.Point(339, 235)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(40, 13)
        Me.Label12.TabIndex = 32
        Me.Label12.Text = "ClientID"
        '
        'clientid
        '
        Me.clientid.Location = New System.Drawing.Point(434, 228)
        Me.clientid.Name = "clientid"
        Me.clientid.Size = New System.Drawing.Size(197, 20)
        Me.clientid.TabIndex = 31
        '
        'Label13
        '
        Me.Label13.AutoSize = True
        Me.Label13.Location = New System.Drawing.Point(19, 241)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(60, 13)
        Me.Label13.TabIndex = 34
        Me.Label13.Text = "InlineReport"
        '
        'InLineReport
        '
        Me.InLineReport.Location = New System.Drawing.Point(114, 234)
        Me.InLineReport.Name = "InLineReport"
        Me.InLineReport.Size = New System.Drawing.Size(197, 20)
        Me.InLineReport.TabIndex = 33
        '
        'Timer1
        '
        Me.Timer1.Enabled = True
        Me.Timer1.Interval = 2000
        '
        'Label14
        '
        Me.Label14.AutoSize = True
        Me.Label14.Location = New System.Drawing.Point(3, 344)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(61, 13)
        Me.Label14.TabIndex = 35
        Me.Label14.Text = "CurrentTask"
        '
        'Label15
        '
        Me.Label15.AutoSize = True
        Me.Label15.Location = New System.Drawing.Point(248, 344)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(85, 13)
        Me.Label15.TabIndex = 36
        Me.Label15.Text = "Server Messages"
        '
        'Label16
        '
        Me.Label16.AutoSize = True
        Me.Label16.Location = New System.Drawing.Point(446, 344)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(30, 13)
        Me.Label16.TabIndex = 37
        Me.Label16.Text = "Errors"
        '
        'Label17
        '
        Me.Label17.AutoSize = True
        Me.Label17.Location = New System.Drawing.Point(183, 465)
        Me.Label17.Name = "Label17"
        Me.Label17.Size = New System.Drawing.Size(109, 13)
        Me.Label17.TabIndex = 38
        Me.Label17.Text = "Time to server contact"
        '
        'Label18
        '
        Me.Label18.AutoSize = True
        Me.Label18.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label18.Location = New System.Drawing.Point(323, 69)
        Me.Label18.Name = "Label18"
        Me.Label18.Size = New System.Drawing.Size(45, 13)
        Me.Label18.TabIndex = 40
        Me.Label18.Text = "runsafe"
        '
        'runsafe
        '
        Me.runsafe.Location = New System.Drawing.Point(434, 62)
        Me.runsafe.Name = "runsafe"
        Me.runsafe.Size = New System.Drawing.Size(197, 20)
        Me.runsafe.TabIndex = 39
        '
        'Label19
        '
        Me.Label19.AutoSize = True
        Me.Label19.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label19.Location = New System.Drawing.Point(21, 291)
        Me.Label19.Name = "Label19"
        Me.Label19.Size = New System.Drawing.Size(55, 13)
        Me.Label19.TabIndex = 42
        Me.Label19.Text = "CheckedIn"
        '
        'checkedin
        '
        Me.checkedin.Location = New System.Drawing.Point(82, 284)
        Me.checkedin.Name = "checkedin"
        Me.checkedin.Size = New System.Drawing.Size(87, 20)
        Me.checkedin.TabIndex = 41
        '
        'Label20
        '
        Me.Label20.AutoSize = True
        Me.Label20.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label20.Location = New System.Drawing.Point(339, 291)
        Me.Label20.Name = "Label20"
        Me.Label20.Size = New System.Drawing.Size(81, 13)
        Me.Label20.TabIndex = 44
        Me.Label20.Text = "NeuronChecked"
        '
        'neuronstatus
        '
        Me.neuronstatus.Location = New System.Drawing.Point(258, 284)
        Me.neuronstatus.Name = "neuronstatus"
        Me.neuronstatus.Size = New System.Drawing.Size(64, 20)
        Me.neuronstatus.TabIndex = 43
        '
        'Label21
        '
        Me.Label21.AutoSize = True
        Me.Label21.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label21.Location = New System.Drawing.Point(184, 291)
        Me.Label21.Name = "Label21"
        Me.Label21.Size = New System.Drawing.Size(68, 13)
        Me.Label21.TabIndex = 46
        Me.Label21.Text = "NeuronStatus"
        '
        'neurontouched
        '
        Me.neurontouched.Location = New System.Drawing.Point(426, 284)
        Me.neurontouched.Name = "neurontouched"
        Me.neurontouched.Size = New System.Drawing.Size(143, 20)
        Me.neurontouched.TabIndex = 45
        '
        'Label22
        '
        Me.Label22.AutoSize = True
        Me.Label22.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label22.Location = New System.Drawing.Point(3, 95)
        Me.Label22.Name = "Label22"
        Me.Label22.Size = New System.Drawing.Size(120, 13)
        Me.Label22.TabIndex = 48
        Me.Label22.Text = "NeuronTimeout (min)"
        '
        'neurontimeout
        '
        Me.neurontimeout.Location = New System.Drawing.Point(130, 88)
        Me.neurontimeout.Name = "neurontimeout"
        Me.neurontimeout.Size = New System.Drawing.Size(181, 20)
        Me.neurontimeout.TabIndex = 47
        '
        'Label23
        '
        Me.Label23.AutoSize = True
        Me.Label23.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label23.Location = New System.Drawing.Point(21, 317)
        Me.Label23.Name = "Label23"
        Me.Label23.Size = New System.Drawing.Size(34, 13)
        Me.Label23.TabIndex = 50
        Me.Label23.Text = "Pdone"
        '
        'Pdone
        '
        Me.Pdone.Location = New System.Drawing.Point(82, 310)
        Me.Pdone.Name = "Pdone"
        Me.Pdone.Size = New System.Drawing.Size(87, 20)
        Me.Pdone.TabIndex = 49
        '
        'Label24
        '
        Me.Label24.AutoSize = True
        Me.Label24.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label24.Location = New System.Drawing.Point(339, 257)
        Me.Label24.Name = "Label24"
        Me.Label24.Size = New System.Drawing.Size(59, 13)
        Me.Label24.TabIndex = 53
        Me.Label24.Text = "NeuronFails"
        '
        'timeouts
        '
        Me.timeouts.Location = New System.Drawing.Point(434, 254)
        Me.timeouts.Name = "timeouts"
        Me.timeouts.Size = New System.Drawing.Size(87, 20)
        Me.timeouts.TabIndex = 52
        '
        'Label25
        '
        Me.Label25.AutoSize = True
        Me.Label25.Location = New System.Drawing.Point(12, 126)
        Me.Label25.Name = "Label25"
        Me.Label25.Size = New System.Drawing.Size(229, 13)
        Me.Label25.TabIndex = 54
        Me.Label25.Text = "The rest of this form is for debugging and testing"
        '
        'TestConn
        '
        Me.TestConn.Location = New System.Drawing.Point(418, 88)
        Me.TestConn.Name = "TestConn"
        Me.TestConn.Size = New System.Drawing.Size(67, 23)
        Me.TestConn.TabIndex = 55
        Me.TestConn.Text = "TestConn"
        '
        'Reset
        '
        Me.Reset.Location = New System.Drawing.Point(491, 88)
        Me.Reset.Name = "Reset"
        Me.Reset.Size = New System.Drawing.Size(67, 23)
        Me.Reset.TabIndex = 56
        Me.Reset.Text = "Reset"
        '
        'OptionsForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(651, 529)
        Me.Controls.Add(Me.Reset)
        Me.Controls.Add(Me.TestConn)
        Me.Controls.Add(Me.Label25)
        Me.Controls.Add(Me.Label24)
        Me.Controls.Add(Me.timeouts)
        Me.Controls.Add(Me.Label23)
        Me.Controls.Add(Me.Pdone)
        Me.Controls.Add(Me.Label22)
        Me.Controls.Add(Me.neurontimeout)
        Me.Controls.Add(Me.Label21)
        Me.Controls.Add(Me.neurontouched)
        Me.Controls.Add(Me.Label20)
        Me.Controls.Add(Me.neuronstatus)
        Me.Controls.Add(Me.Label19)
        Me.Controls.Add(Me.checkedin)
        Me.Controls.Add(Me.Label18)
        Me.Controls.Add(Me.runsafe)
        Me.Controls.Add(Me.Label17)
        Me.Controls.Add(Me.Label16)
        Me.Controls.Add(Me.Label15)
        Me.Controls.Add(Me.Label14)
        Me.Controls.Add(Me.Label13)
        Me.Controls.Add(Me.InLineReport)
        Me.Controls.Add(Me.Label12)
        Me.Controls.Add(Me.clientid)
        Me.Controls.Add(Me.Label11)
        Me.Controls.Add(Me.modelparams)
        Me.Controls.Add(Me.Label10)
        Me.Controls.Add(Me.modelstart)
        Me.Controls.Add(Me.Button4)
        Me.Controls.Add(Me.Button2)
        Me.Controls.Add(Me.waittill)
        Me.Controls.Add(Me.Save_Settings)
        Me.Controls.Add(Me.Label9)
        Me.Controls.Add(Me.Label8)
        Me.Controls.Add(Me.Label7)
        Me.Controls.Add(Me.Label6)
        Me.Controls.Add(Me.Label5)
        Me.Controls.Add(Me.Label4)
        Me.Controls.Add(Me.Label3)
        Me.Controls.Add(Me.Label2)
        Me.Controls.Add(Me.Label1)
        Me.Controls.Add(Me.modelversion)
        Me.Controls.Add(Me.blocksize)
        Me.Controls.Add(Me.workstart)
        Me.Controls.Add(Me.modeldir)
        Me.Controls.Add(Me.password)
        Me.Controls.Add(Me.Server)
        Me.Controls.Add(Me.NSweepDir)
        Me.Controls.Add(Me.NrnivCmd)
        Me.Controls.Add(Me.NrnivDir)
        Me.Controls.Add(Me.errorlog)
        Me.Controls.Add(Me.servermessages)
        Me.Controls.Add(Me.currenttask)
        Me.Controls.Add(Me.Button1)
        Me.Name = "OptionsForm"
        Me.Padding = New System.Windows.Forms.Padding(9)
        Me.ShowIcon = False
        Me.Text = "Screen Saver Settings"
        Me.ResumeLayout(False)
        Me.PerformLayout()

    End Sub
    Friend WithEvents Button1 As System.Windows.Forms.Button
    Friend WithEvents currenttask As System.Windows.Forms.TextBox
    Friend WithEvents servermessages As System.Windows.Forms.TextBox
    Friend WithEvents errorlog As System.Windows.Forms.TextBox
    Friend WithEvents NrnivDir As System.Windows.Forms.TextBox
    Friend WithEvents NrnivCmd As System.Windows.Forms.TextBox
    Friend WithEvents NSweepDir As System.Windows.Forms.TextBox
    Friend WithEvents Server As System.Windows.Forms.TextBox
    Friend WithEvents password As System.Windows.Forms.TextBox
    Friend WithEvents modeldir As System.Windows.Forms.TextBox
    Friend WithEvents workstart As System.Windows.Forms.TextBox
    Friend WithEvents blocksize As System.Windows.Forms.TextBox
    Friend WithEvents modelversion As System.Windows.Forms.TextBox
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents Save_Settings As System.Windows.Forms.Button
    Friend WithEvents waittill As System.Windows.Forms.TextBox
    Friend WithEvents Button2 As System.Windows.Forms.Button
    Friend WithEvents Button4 As System.Windows.Forms.Button
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents modelstart As System.Windows.Forms.TextBox
    Friend WithEvents Label11 As System.Windows.Forms.Label
    Friend WithEvents modelparams As System.Windows.Forms.TextBox
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents clientid As System.Windows.Forms.TextBox
    Friend WithEvents Label13 As System.Windows.Forms.Label
    Friend WithEvents InLineReport As System.Windows.Forms.TextBox
    Friend WithEvents Timer1 As System.Windows.Forms.Timer
    Friend WithEvents Label14 As System.Windows.Forms.Label
    Friend WithEvents Label15 As System.Windows.Forms.Label
    Friend WithEvents Label16 As System.Windows.Forms.Label
    Friend WithEvents Label17 As System.Windows.Forms.Label
    Friend WithEvents Label18 As System.Windows.Forms.Label
    Friend WithEvents runsafe As System.Windows.Forms.TextBox
    Friend WithEvents Label19 As System.Windows.Forms.Label
    Friend WithEvents checkedin As System.Windows.Forms.TextBox
    Friend WithEvents Label20 As System.Windows.Forms.Label
    Friend WithEvents neuronstatus As System.Windows.Forms.TextBox
    Friend WithEvents Label21 As System.Windows.Forms.Label
    Friend WithEvents neurontouched As System.Windows.Forms.TextBox
    Friend WithEvents Label22 As System.Windows.Forms.Label
    Friend WithEvents neurontimeout As System.Windows.Forms.TextBox
    Friend WithEvents Label23 As System.Windows.Forms.Label
    Friend WithEvents Pdone As System.Windows.Forms.TextBox
    Friend WithEvents Label24 As System.Windows.Forms.Label
    Friend WithEvents timeouts As System.Windows.Forms.TextBox
    Friend WithEvents Label25 As System.Windows.Forms.Label
    Friend WithEvents TestConn As System.Windows.Forms.Button
    Friend WithEvents Reset As System.Windows.Forms.Button
    'InitializeComponent 
End Class
