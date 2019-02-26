<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Public Class ScreenSaverForm
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
        Me.backgroundChangeTimer = New System.Windows.Forms.Timer(Me.components)
        Me.Panel1 = New System.Windows.Forms.Panel
        Me.Label24 = New System.Windows.Forms.Label
        Me.timeouts = New System.Windows.Forms.TextBox
        Me.Label23 = New System.Windows.Forms.Label
        Me.Pdone = New System.Windows.Forms.TextBox
        Me.Label21 = New System.Windows.Forms.Label
        Me.neurontouched = New System.Windows.Forms.TextBox
        Me.Label20 = New System.Windows.Forms.Label
        Me.neuronstatus = New System.Windows.Forms.TextBox
        Me.Label19 = New System.Windows.Forms.Label
        Me.checkedin = New System.Windows.Forms.TextBox
        Me.Label17 = New System.Windows.Forms.Label
        Me.Label16 = New System.Windows.Forms.Label
        Me.Label15 = New System.Windows.Forms.Label
        Me.Label14 = New System.Windows.Forms.Label
        Me.Label13 = New System.Windows.Forms.Label
        Me.InLineReport = New System.Windows.Forms.TextBox
        Me.Label12 = New System.Windows.Forms.Label
        Me.clientid = New System.Windows.Forms.TextBox
        Me.Label11 = New System.Windows.Forms.Label
        Me.modelparams = New System.Windows.Forms.TextBox
        Me.Label10 = New System.Windows.Forms.Label
        Me.modelstart = New System.Windows.Forms.TextBox
        Me.waittill = New System.Windows.Forms.TextBox
        Me.Label9 = New System.Windows.Forms.Label
        Me.Label8 = New System.Windows.Forms.Label
        Me.Label7 = New System.Windows.Forms.Label
        Me.Label6 = New System.Windows.Forms.Label
        Me.modelversion = New System.Windows.Forms.TextBox
        Me.blocksize = New System.Windows.Forms.TextBox
        Me.workstart = New System.Windows.Forms.TextBox
        Me.modeldir = New System.Windows.Forms.TextBox
        Me.errorlog = New System.Windows.Forms.TextBox
        Me.servermessages = New System.Windows.Forms.TextBox
        Me.currenttask = New System.Windows.Forms.TextBox
        Me.Label22 = New System.Windows.Forms.Label
        Me.neurontimeout = New System.Windows.Forms.TextBox
        Me.Label18 = New System.Windows.Forms.Label
        Me.runsafe = New System.Windows.Forms.TextBox
        Me.Label5 = New System.Windows.Forms.Label
        Me.Label4 = New System.Windows.Forms.Label
        Me.Label3 = New System.Windows.Forms.Label
        Me.Label2 = New System.Windows.Forms.Label
        Me.Label1 = New System.Windows.Forms.Label
        Me.password = New System.Windows.Forms.TextBox
        Me.Server = New System.Windows.Forms.TextBox
        Me.NSweepDir = New System.Windows.Forms.TextBox
        Me.NrnivCmd = New System.Windows.Forms.TextBox
        Me.NrnivDir = New System.Windows.Forms.TextBox
        Me.PictureBox1 = New System.Windows.Forms.PictureBox
        Me.PictureBox2 = New System.Windows.Forms.PictureBox
        Me.Panel1.SuspendLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).BeginInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).BeginInit()
        Me.SuspendLayout()
        '
        'backgroundChangeTimer
        '
        Me.backgroundChangeTimer.Enabled = True
        Me.backgroundChangeTimer.Interval = 2000
        '
        'Panel1
        '
        Me.Panel1.Controls.Add(Me.Label24)
        Me.Panel1.Controls.Add(Me.timeouts)
        Me.Panel1.Controls.Add(Me.Label23)
        Me.Panel1.Controls.Add(Me.Pdone)
        Me.Panel1.Controls.Add(Me.Label21)
        Me.Panel1.Controls.Add(Me.neurontouched)
        Me.Panel1.Controls.Add(Me.Label20)
        Me.Panel1.Controls.Add(Me.neuronstatus)
        Me.Panel1.Controls.Add(Me.Label19)
        Me.Panel1.Controls.Add(Me.checkedin)
        Me.Panel1.Controls.Add(Me.Label17)
        Me.Panel1.Controls.Add(Me.Label16)
        Me.Panel1.Controls.Add(Me.Label15)
        Me.Panel1.Controls.Add(Me.Label14)
        Me.Panel1.Controls.Add(Me.Label13)
        Me.Panel1.Controls.Add(Me.InLineReport)
        Me.Panel1.Controls.Add(Me.Label12)
        Me.Panel1.Controls.Add(Me.clientid)
        Me.Panel1.Controls.Add(Me.Label11)
        Me.Panel1.Controls.Add(Me.modelparams)
        Me.Panel1.Controls.Add(Me.Label10)
        Me.Panel1.Controls.Add(Me.modelstart)
        Me.Panel1.Controls.Add(Me.waittill)
        Me.Panel1.Controls.Add(Me.Label9)
        Me.Panel1.Controls.Add(Me.Label8)
        Me.Panel1.Controls.Add(Me.Label7)
        Me.Panel1.Controls.Add(Me.Label6)
        Me.Panel1.Controls.Add(Me.modelversion)
        Me.Panel1.Controls.Add(Me.blocksize)
        Me.Panel1.Controls.Add(Me.workstart)
        Me.Panel1.Controls.Add(Me.modeldir)
        Me.Panel1.Controls.Add(Me.errorlog)
        Me.Panel1.Controls.Add(Me.servermessages)
        Me.Panel1.Controls.Add(Me.currenttask)
        Me.Panel1.Controls.Add(Me.Label22)
        Me.Panel1.Controls.Add(Me.neurontimeout)
        Me.Panel1.Controls.Add(Me.Label18)
        Me.Panel1.Controls.Add(Me.runsafe)
        Me.Panel1.Controls.Add(Me.Label5)
        Me.Panel1.Controls.Add(Me.Label4)
        Me.Panel1.Controls.Add(Me.Label3)
        Me.Panel1.Controls.Add(Me.Label2)
        Me.Panel1.Controls.Add(Me.Label1)
        Me.Panel1.Controls.Add(Me.password)
        Me.Panel1.Controls.Add(Me.Server)
        Me.Panel1.Controls.Add(Me.NSweepDir)
        Me.Panel1.Controls.Add(Me.NrnivCmd)
        Me.Panel1.Controls.Add(Me.NrnivDir)
        Me.Panel1.Controls.Add(Me.PictureBox1)
        Me.Panel1.Location = New System.Drawing.Point(13, 71)
        Me.Panel1.Name = "Panel1"
        Me.Panel1.Size = New System.Drawing.Size(643, 511)
        Me.Panel1.TabIndex = 0
        '
        'Label24
        '
        Me.Label24.AutoSize = True
        Me.Label24.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label24.Location = New System.Drawing.Point(338, 282)
        Me.Label24.Name = "Label24"
        Me.Label24.Size = New System.Drawing.Size(59, 13)
        Me.Label24.TabIndex = 121
        Me.Label24.Text = "NeuronFails"
        '
        'timeouts
        '
        Me.timeouts.Enabled = False
        Me.timeouts.Location = New System.Drawing.Point(433, 279)
        Me.timeouts.Name = "timeouts"
        Me.timeouts.Size = New System.Drawing.Size(87, 20)
        Me.timeouts.TabIndex = 120
        '
        'Label23
        '
        Me.Label23.AutoSize = True
        Me.Label23.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label23.Location = New System.Drawing.Point(20, 342)
        Me.Label23.Name = "Label23"
        Me.Label23.Size = New System.Drawing.Size(34, 13)
        Me.Label23.TabIndex = 119
        Me.Label23.Text = "Pdone"
        '
        'Pdone
        '
        Me.Pdone.Enabled = False
        Me.Pdone.Location = New System.Drawing.Point(81, 335)
        Me.Pdone.Name = "Pdone"
        Me.Pdone.Size = New System.Drawing.Size(87, 20)
        Me.Pdone.TabIndex = 118
        '
        'Label21
        '
        Me.Label21.AutoSize = True
        Me.Label21.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label21.Location = New System.Drawing.Point(183, 316)
        Me.Label21.Name = "Label21"
        Me.Label21.Size = New System.Drawing.Size(68, 13)
        Me.Label21.TabIndex = 117
        Me.Label21.Text = "NeuronStatus"
        '
        'neurontouched
        '
        Me.neurontouched.Enabled = False
        Me.neurontouched.Location = New System.Drawing.Point(425, 309)
        Me.neurontouched.Name = "neurontouched"
        Me.neurontouched.Size = New System.Drawing.Size(143, 20)
        Me.neurontouched.TabIndex = 116
        '
        'Label20
        '
        Me.Label20.AutoSize = True
        Me.Label20.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label20.Location = New System.Drawing.Point(338, 316)
        Me.Label20.Name = "Label20"
        Me.Label20.Size = New System.Drawing.Size(81, 13)
        Me.Label20.TabIndex = 115
        Me.Label20.Text = "NeuronChecked"
        '
        'neuronstatus
        '
        Me.neuronstatus.Enabled = False
        Me.neuronstatus.Location = New System.Drawing.Point(257, 309)
        Me.neuronstatus.Name = "neuronstatus"
        Me.neuronstatus.Size = New System.Drawing.Size(64, 20)
        Me.neuronstatus.TabIndex = 114
        '
        'Label19
        '
        Me.Label19.AutoSize = True
        Me.Label19.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label19.Location = New System.Drawing.Point(20, 316)
        Me.Label19.Name = "Label19"
        Me.Label19.Size = New System.Drawing.Size(55, 13)
        Me.Label19.TabIndex = 113
        Me.Label19.Text = "CheckedIn"
        '
        'checkedin
        '
        Me.checkedin.Enabled = False
        Me.checkedin.Location = New System.Drawing.Point(81, 309)
        Me.checkedin.Name = "checkedin"
        Me.checkedin.Size = New System.Drawing.Size(87, 20)
        Me.checkedin.TabIndex = 112
        '
        'Label17
        '
        Me.Label17.AutoSize = True
        Me.Label17.Location = New System.Drawing.Point(182, 490)
        Me.Label17.Name = "Label17"
        Me.Label17.Size = New System.Drawing.Size(109, 13)
        Me.Label17.TabIndex = 111
        Me.Label17.Text = "Time to server contact"
        '
        'Label16
        '
        Me.Label16.AutoSize = True
        Me.Label16.Location = New System.Drawing.Point(445, 369)
        Me.Label16.Name = "Label16"
        Me.Label16.Size = New System.Drawing.Size(30, 13)
        Me.Label16.TabIndex = 110
        Me.Label16.Text = "Errors"
        '
        'Label15
        '
        Me.Label15.AutoSize = True
        Me.Label15.Location = New System.Drawing.Point(247, 369)
        Me.Label15.Name = "Label15"
        Me.Label15.Size = New System.Drawing.Size(85, 13)
        Me.Label15.TabIndex = 109
        Me.Label15.Text = "Server Messages"
        '
        'Label14
        '
        Me.Label14.AutoSize = True
        Me.Label14.Location = New System.Drawing.Point(2, 369)
        Me.Label14.Name = "Label14"
        Me.Label14.Size = New System.Drawing.Size(61, 13)
        Me.Label14.TabIndex = 108
        Me.Label14.Text = "CurrentTask"
        '
        'Label13
        '
        Me.Label13.AutoSize = True
        Me.Label13.Location = New System.Drawing.Point(18, 266)
        Me.Label13.Name = "Label13"
        Me.Label13.Size = New System.Drawing.Size(60, 13)
        Me.Label13.TabIndex = 107
        Me.Label13.Text = "InlineReport"
        '
        'InLineReport
        '
        Me.InLineReport.Enabled = False
        Me.InLineReport.Location = New System.Drawing.Point(113, 259)
        Me.InLineReport.Name = "InLineReport"
        Me.InLineReport.Size = New System.Drawing.Size(197, 20)
        Me.InLineReport.TabIndex = 106
        '
        'Label12
        '
        Me.Label12.AutoSize = True
        Me.Label12.Location = New System.Drawing.Point(338, 260)
        Me.Label12.Name = "Label12"
        Me.Label12.Size = New System.Drawing.Size(40, 13)
        Me.Label12.TabIndex = 105
        Me.Label12.Text = "ClientID"
        '
        'clientid
        '
        Me.clientid.Enabled = False
        Me.clientid.Location = New System.Drawing.Point(433, 253)
        Me.clientid.Name = "clientid"
        Me.clientid.Size = New System.Drawing.Size(197, 20)
        Me.clientid.TabIndex = 104
        '
        'Label11
        '
        Me.Label11.AutoSize = True
        Me.Label11.Location = New System.Drawing.Point(338, 182)
        Me.Label11.Name = "Label11"
        Me.Label11.Size = New System.Drawing.Size(66, 13)
        Me.Label11.TabIndex = 103
        Me.Label11.Text = "Modelparams"
        '
        'modelparams
        '
        Me.modelparams.Enabled = False
        Me.modelparams.Location = New System.Drawing.Point(433, 175)
        Me.modelparams.Name = "modelparams"
        Me.modelparams.Size = New System.Drawing.Size(197, 20)
        Me.modelparams.TabIndex = 102
        '
        'Label10
        '
        Me.Label10.AutoSize = True
        Me.Label10.Location = New System.Drawing.Point(18, 240)
        Me.Label10.Name = "Label10"
        Me.Label10.Size = New System.Drawing.Size(52, 13)
        Me.Label10.TabIndex = 101
        Me.Label10.Text = "Modelstart"
        '
        'modelstart
        '
        Me.modelstart.Enabled = False
        Me.modelstart.Location = New System.Drawing.Point(113, 233)
        Me.modelstart.Name = "modelstart"
        Me.modelstart.Size = New System.Drawing.Size(197, 20)
        Me.modelstart.TabIndex = 100
        '
        'waittill
        '
        Me.waittill.Enabled = False
        Me.waittill.Location = New System.Drawing.Point(310, 483)
        Me.waittill.Name = "waittill"
        Me.waittill.Size = New System.Drawing.Size(188, 20)
        Me.waittill.TabIndex = 99
        '
        'Label9
        '
        Me.Label9.AutoSize = True
        Me.Label9.Location = New System.Drawing.Point(18, 185)
        Me.Label9.Name = "Label9"
        Me.Label9.Size = New System.Drawing.Size(67, 13)
        Me.Label9.TabIndex = 98
        Me.Label9.Text = "ModelVersion"
        '
        'Label8
        '
        Me.Label8.AutoSize = True
        Me.Label8.Location = New System.Drawing.Point(338, 234)
        Me.Label8.Name = "Label8"
        Me.Label8.Size = New System.Drawing.Size(48, 13)
        Me.Label8.TabIndex = 97
        Me.Label8.Text = "Blocksize"
        '
        'Label7
        '
        Me.Label7.AutoSize = True
        Me.Label7.Location = New System.Drawing.Point(338, 208)
        Me.Label7.Name = "Label7"
        Me.Label7.Size = New System.Drawing.Size(49, 13)
        Me.Label7.TabIndex = 96
        Me.Label7.Text = "Workstart"
        '
        'Label6
        '
        Me.Label6.AutoSize = True
        Me.Label6.Location = New System.Drawing.Point(18, 211)
        Me.Label6.Name = "Label6"
        Me.Label6.Size = New System.Drawing.Size(32, 13)
        Me.Label6.TabIndex = 95
        Me.Label6.Text = "Model"
        '
        'modelversion
        '
        Me.modelversion.Enabled = False
        Me.modelversion.Location = New System.Drawing.Point(113, 178)
        Me.modelversion.Name = "modelversion"
        Me.modelversion.Size = New System.Drawing.Size(197, 20)
        Me.modelversion.TabIndex = 94
        '
        'blocksize
        '
        Me.blocksize.Enabled = False
        Me.blocksize.Location = New System.Drawing.Point(433, 227)
        Me.blocksize.Name = "blocksize"
        Me.blocksize.Size = New System.Drawing.Size(197, 20)
        Me.blocksize.TabIndex = 93
        '
        'workstart
        '
        Me.workstart.Enabled = False
        Me.workstart.Location = New System.Drawing.Point(433, 201)
        Me.workstart.Name = "workstart"
        Me.workstart.Size = New System.Drawing.Size(197, 20)
        Me.workstart.TabIndex = 92
        '
        'modeldir
        '
        Me.modeldir.Enabled = False
        Me.modeldir.Location = New System.Drawing.Point(113, 204)
        Me.modeldir.Name = "modeldir"
        Me.modeldir.Size = New System.Drawing.Size(197, 20)
        Me.modeldir.TabIndex = 91
        '
        'errorlog
        '
        Me.errorlog.Enabled = False
        Me.errorlog.Location = New System.Drawing.Point(446, 385)
        Me.errorlog.Multiline = True
        Me.errorlog.Name = "errorlog"
        Me.errorlog.Size = New System.Drawing.Size(192, 92)
        Me.errorlog.TabIndex = 90
        '
        'servermessages
        '
        Me.servermessages.Enabled = False
        Me.servermessages.Location = New System.Drawing.Point(248, 385)
        Me.servermessages.Multiline = True
        Me.servermessages.Name = "servermessages"
        Me.servermessages.Size = New System.Drawing.Size(192, 92)
        Me.servermessages.TabIndex = 89
        '
        'currenttask
        '
        Me.currenttask.Enabled = False
        Me.currenttask.Location = New System.Drawing.Point(3, 385)
        Me.currenttask.Multiline = True
        Me.currenttask.Name = "currenttask"
        Me.currenttask.Size = New System.Drawing.Size(239, 92)
        Me.currenttask.TabIndex = 88
        '
        'Label22
        '
        Me.Label22.AutoSize = True
        Me.Label22.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label22.Location = New System.Drawing.Point(12, 148)
        Me.Label22.Name = "Label22"
        Me.Label22.Size = New System.Drawing.Size(120, 13)
        Me.Label22.TabIndex = 87
        Me.Label22.Text = "NeuronTimeout (min)"
        '
        'neurontimeout
        '
        Me.neurontimeout.Enabled = False
        Me.neurontimeout.Location = New System.Drawing.Point(139, 141)
        Me.neurontimeout.Name = "neurontimeout"
        Me.neurontimeout.Size = New System.Drawing.Size(181, 20)
        Me.neurontimeout.TabIndex = 86
        '
        'Label18
        '
        Me.Label18.AutoSize = True
        Me.Label18.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label18.Location = New System.Drawing.Point(332, 122)
        Me.Label18.Name = "Label18"
        Me.Label18.Size = New System.Drawing.Size(45, 13)
        Me.Label18.TabIndex = 85
        Me.Label18.Text = "runsafe"
        '
        'runsafe
        '
        Me.runsafe.Enabled = False
        Me.runsafe.Location = New System.Drawing.Point(443, 115)
        Me.runsafe.Name = "runsafe"
        Me.runsafe.Size = New System.Drawing.Size(197, 20)
        Me.runsafe.TabIndex = 84
        '
        'Label5
        '
        Me.Label5.AutoSize = True
        Me.Label5.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label5.Location = New System.Drawing.Point(332, 96)
        Me.Label5.Name = "Label5"
        Me.Label5.Size = New System.Drawing.Size(93, 13)
        Me.Label5.TabIndex = 83
        Me.Label5.Text = "Client Password"
        '
        'Label4
        '
        Me.Label4.AutoSize = True
        Me.Label4.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label4.Location = New System.Drawing.Point(332, 70)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(40, 13)
        Me.Label4.TabIndex = 82
        Me.Label4.Text = "Server"
        '
        'Label3
        '
        Me.Label3.AutoSize = True
        Me.Label3.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(12, 122)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(105, 13)
        Me.Label3.TabIndex = 81
        Me.Label3.Text = "NSweep Directory"
        '
        'Label2
        '
        Me.Label2.AutoSize = True
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label2.Location = New System.Drawing.Point(12, 96)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(102, 13)
        Me.Label2.TabIndex = 80
        Me.Label2.Text = "Neuron Command"
        '
        'Label1
        '
        Me.Label1.AutoSize = True
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 8.25!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(12, 70)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(99, 13)
        Me.Label1.TabIndex = 79
        Me.Label1.Text = "Neuron Directory"
        '
        'password
        '
        Me.password.Enabled = False
        Me.password.Location = New System.Drawing.Point(443, 89)
        Me.password.Name = "password"
        Me.password.Size = New System.Drawing.Size(197, 20)
        Me.password.TabIndex = 78
        '
        'Server
        '
        Me.Server.Enabled = False
        Me.Server.Location = New System.Drawing.Point(443, 63)
        Me.Server.Name = "Server"
        Me.Server.Size = New System.Drawing.Size(197, 20)
        Me.Server.TabIndex = 77
        '
        'NSweepDir
        '
        Me.NSweepDir.Enabled = False
        Me.NSweepDir.Location = New System.Drawing.Point(123, 115)
        Me.NSweepDir.Name = "NSweepDir"
        Me.NSweepDir.Size = New System.Drawing.Size(197, 20)
        Me.NSweepDir.TabIndex = 76
        '
        'NrnivCmd
        '
        Me.NrnivCmd.Enabled = False
        Me.NrnivCmd.Location = New System.Drawing.Point(123, 89)
        Me.NrnivCmd.Name = "NrnivCmd"
        Me.NrnivCmd.Size = New System.Drawing.Size(197, 20)
        Me.NrnivCmd.TabIndex = 75
        '
        'NrnivDir
        '
        Me.NrnivDir.Enabled = False
        Me.NrnivDir.Location = New System.Drawing.Point(123, 63)
        Me.NrnivDir.Name = "NrnivDir"
        Me.NrnivDir.Size = New System.Drawing.Size(197, 20)
        Me.NrnivDir.TabIndex = 74
        '
        'PictureBox1
        '
        Me.PictureBox1.Image = neuronPM.My.Resources.Resources.title
        Me.PictureBox1.InitialImage = neuronPM.My.Resources.Resources.title
        Me.PictureBox1.Location = New System.Drawing.Point(17, 3)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(620, 54)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.CenterImage
        Me.PictureBox1.TabIndex = 73
        Me.PictureBox1.TabStop = False
        '
        'PictureBox2
        '
        Me.PictureBox2.Image = neuronPM.My.Resources.Resources.title
        Me.PictureBox2.InitialImage = neuronPM.My.Resources.Resources.title
        Me.PictureBox2.Location = New System.Drawing.Point(13, -2)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(385, 67)
        Me.PictureBox2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox2.TabIndex = 74
        Me.PictureBox2.TabStop = False
        '
        'ScreenSaverForm
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(676, 600)
        Me.Controls.Add(Me.PictureBox2)
        Me.Controls.Add(Me.Panel1)
        Me.DoubleBuffered = True
        Me.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None
        Me.Name = "ScreenSaverForm"
        Me.ShowInTaskbar = False
        Me.TopMost = True
        Me.WindowState = System.Windows.Forms.FormWindowState.Maximized
        Me.Panel1.ResumeLayout(False)
        Me.Panel1.PerformLayout()
        CType(Me.PictureBox1, System.ComponentModel.ISupportInitialize).EndInit()
        CType(Me.PictureBox2, System.ComponentModel.ISupportInitialize).EndInit()
        Me.ResumeLayout(False)

    End Sub

    Private WithEvents backgroundChangeTimer As System.Windows.Forms.Timer
    Friend WithEvents Panel1 As System.Windows.Forms.Panel
    Friend WithEvents PictureBox2 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents Label22 As System.Windows.Forms.Label
    Friend WithEvents neurontimeout As System.Windows.Forms.TextBox
    Friend WithEvents Label18 As System.Windows.Forms.Label
    Friend WithEvents runsafe As System.Windows.Forms.TextBox
    Friend WithEvents Label5 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents password As System.Windows.Forms.TextBox
    Friend WithEvents Server As System.Windows.Forms.TextBox
    Friend WithEvents NSweepDir As System.Windows.Forms.TextBox
    Friend WithEvents NrnivCmd As System.Windows.Forms.TextBox
    Friend WithEvents NrnivDir As System.Windows.Forms.TextBox
    Friend WithEvents Label24 As System.Windows.Forms.Label
    Friend WithEvents timeouts As System.Windows.Forms.TextBox
    Friend WithEvents Label23 As System.Windows.Forms.Label
    Friend WithEvents Pdone As System.Windows.Forms.TextBox
    Friend WithEvents Label21 As System.Windows.Forms.Label
    Friend WithEvents neurontouched As System.Windows.Forms.TextBox
    Friend WithEvents Label20 As System.Windows.Forms.Label
    Friend WithEvents neuronstatus As System.Windows.Forms.TextBox
    Friend WithEvents Label19 As System.Windows.Forms.Label
    Friend WithEvents checkedin As System.Windows.Forms.TextBox
    Friend WithEvents Label17 As System.Windows.Forms.Label
    Friend WithEvents Label16 As System.Windows.Forms.Label
    Friend WithEvents Label15 As System.Windows.Forms.Label
    Friend WithEvents Label14 As System.Windows.Forms.Label
    Friend WithEvents Label13 As System.Windows.Forms.Label
    Friend WithEvents InLineReport As System.Windows.Forms.TextBox
    Friend WithEvents Label12 As System.Windows.Forms.Label
    Friend WithEvents clientid As System.Windows.Forms.TextBox
    Friend WithEvents Label11 As System.Windows.Forms.Label
    Friend WithEvents modelparams As System.Windows.Forms.TextBox
    Friend WithEvents Label10 As System.Windows.Forms.Label
    Friend WithEvents modelstart As System.Windows.Forms.TextBox
    Friend WithEvents waittill As System.Windows.Forms.TextBox
    Friend WithEvents Label9 As System.Windows.Forms.Label
    Friend WithEvents Label8 As System.Windows.Forms.Label
    Friend WithEvents Label7 As System.Windows.Forms.Label
    Friend WithEvents Label6 As System.Windows.Forms.Label
    Friend WithEvents modelversion As System.Windows.Forms.TextBox
    Friend WithEvents blocksize As System.Windows.Forms.TextBox
    Friend WithEvents workstart As System.Windows.Forms.TextBox
    Friend WithEvents modeldir As System.Windows.Forms.TextBox
    Friend WithEvents errorlog As System.Windows.Forms.TextBox
    Friend WithEvents servermessages As System.Windows.Forms.TextBox
    Friend WithEvents currenttask As System.Windows.Forms.TextBox
End Class
