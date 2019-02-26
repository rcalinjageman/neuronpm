Imports System.Collections.Generic
Imports System.IO


''' <summary>
''' Screen responsible for rendering the primary visual content of the screen saver.  
''' </summary>
''' <remarks>
''' The form is entirely custom drawn using GDI+ graphics objects.  To alter display, 
''' modify graphics code or host new UI controls on the form.  
''' </remarks>
Public Class ScreenSaverForm
    Public neuron As nrniv
    Public neuronon As Boolean
    Public changepicture As Integer
    'stores images to display in the background
    Private backgroundImages As List(Of Image)

    '
    Private changex, changey As Integer
    Private maxspeed As Double
    Private nextneurontick As Date
    Private nextscreenchange As Date
    Const checkneuron = 10
    Const changescreen = 300

    'stores the index of the current image
    Private currentImageIndex As Integer

    ' Keep track of whether the screensaver has become active.
    Private isActive As Boolean = False

    ' Keep track of the location of the mouse
    Private mouseLocation As Point

    'Array of all images we can display
    Private IMAGE_FILE_EXTENSIONS As String() = {"*.bmp", "*.gif", "*.png", "*.jpg", "*.jpeg"}

    Public Sub New()
        InitializeComponent()
        changepicture = 0
        SetupScreenSaver()
        LoadBackgroundImage()


        neuron = New nrniv
        neuronon = True
        loadsettings()
        nextneurontick = DateAdd(DateInterval.Second, -1, Now())
        nextscreenchange = DateAdd(DateInterval.Second, changescreen, Now())
        neurontick()


        If Val(My.Settings.runsafe) < 0 Then
            Panel1.Visible = False
            Me.PictureBox2.Visible = True
        Else
            Panel1.Visible = True
            Me.PictureBox2.Visible = False
        End If

        If Val(My.Settings.runsafe) = -2 Then
            Me.backgroundChangeTimer.Interval = checkneuron * 1000
        End If

        Randomize()
        maxspeed = 25 * (Me.backgroundChangeTimer.Interval / 1000)
        changey = newdir()
        changex = newdir()

    End Sub


    '''<summary>
    '''Set up the main form as a full screen screensaver.
    '''</summary>
    Private Sub SetupScreenSaver()
        ' Use double buffering to improve drawing performance
        Me.SetStyle(ControlStyles.OptimizedDoubleBuffer Or ControlStyles.UserPaint Or ControlStyles.AllPaintingInWmPaint, True)
        ' Capture the mouse
        Me.Capture = True

        ' Set the application to full screen mode and hide the mouse
        Bounds = Screen.PrimaryScreen.Bounds
        WindowState = FormWindowState.Maximized
        ShowInTaskbar = False
        DoubleBuffered = True
        BackgroundImageLayout = ImageLayout.Stretch

    End Sub


    Private Sub LoadBackgroundImage()

        ' Initialize the background images
        backgroundImages = New List(Of Image)
        currentImageIndex = 0

        backgroundImages.Add(My.Resources.dirona_abolineata)
        backgroundImages.Add(My.Resources.melibe)
        backgroundImages.Add(My.Resources.Tochuina)
        backgroundImages.Add(My.Resources.tritonia)
        Me.BackgroundImage = backgroundImages(currentImageIndex)

    End Sub



    Private Sub ScreenSaverForm_MouseMove(ByVal sender As Object, ByVal e As MouseEventArgs) Handles Me.MouseMove
        ' Set IsActive and MouseLocation only the first time this event is called.
        If Not isActive Then
            mouseLocation = MousePosition
            isActive = True
        Else
            ' If the mouse has moved significantly since first call, close.
            If Math.Abs(MousePosition.X - mouseLocation.X) > 10 OrElse Math.Abs(MousePosition.Y - mouseLocation.Y) > 10 Then
                Close()
            End If
        End If

    End Sub


    Private Sub ScreenSaverForm_KeyDown(ByVal sender As Object, ByVal e As KeyEventArgs) Handles Me.KeyDown
        Close()
    End Sub


    Private Sub ScreenSaverForm_MouseDown(ByVal sender As Object, ByVal e As MouseEventArgs) Handles Me.MouseDown
        Close()
    End Sub


    Protected Overrides Sub OnPaintBackground(ByVal e As PaintEventArgs)
        ' Draw the current background image stretched to fill the full screen
        e.Graphics.DrawImage(backgroundImages(currentImageIndex), 0, 0, Size.Width, Size.Height)

    End Sub

    Private Sub neurontick()
        If neuronon Then
            neuron.Control_Loop()
            If Val(My.Settings.runsafe) > -1 Then
                Me.currenttask.Text = neuron.Current_Task & Me.currenttask.Text
                Me.servermessages.Text = neuron.Server_Messages & Me.servermessages.Text
                loadsettings()
                Me.waittill.Text = DateDiff(DateInterval.Second, Now(), neuron.Next_Contact_Date)
                If neuron.Error_Flag Then Me.errorlog.Text = neuron.Error_Message & Me.errorlog.Text
                Me.checkedin.Text = neuron.Checked_In
                Me.neuronstatus.Text = neuron.Is_Running
                Me.Pdone.Text = neuron.p_done
                Me.neurontouched.Text = DateDiff(DateInterval.Second, neuron.Neuron_Touched, Now())
            End If
        End If
        nextneurontick = DateAdd(DateInterval.Second, checkneuron, Now())
    End Sub

    Private Sub backgroundChangeTimerTick(ByVal sender As Object, ByVal e As EventArgs) Handles backgroundChangeTimer.Tick
        If (Now() > nextneurontick) Then neurontick()

        If (Now() > nextscreenchange) Then
            currentImageIndex = (currentImageIndex + 1) Mod backgroundImages.Count
            Me.BackgroundImage = backgroundImages(currentImageIndex)
            nextscreenchange = DateAdd(DateInterval.Second, changescreen, Now())
        End If

        If Val(My.Settings.runsafe) = -1 Then
            bounce(Me.PictureBox2)
        End If


    End Sub

    Private Sub ScreenSaverForm_FormClosing(ByVal sender As System.Object, ByVal e As System.Windows.Forms.FormClosingEventArgs) Handles MyBase.FormClosing
        If neuronon Then neuron.Check_Out()
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

    Private Function newdir() As Integer
        Dim i As Integer
        i = CInt(Int((maxspeed) * Rnd() + 1))
        Return i
    End Function

    Private Sub bounce(ByVal ob As Control)
        Dim newpos As New Point
        newpos = ob.Location

        newpos.X = newpos.X + changex
        If (newpos.X < 0) Or ((newpos.X + ob.Height) > Me.Height) Then
            newpos.X = newpos.X - changex
            If changex < 0 Then changex = newdir() Else changex = newdir() * -1
        End If

        newpos.Y = newpos.Y + changey
        If (newpos.Y < 0) Or ((newpos.Y + ob.Width) > Me.Width) Then
            newpos.Y = newpos.Y - changey
            If changey < 0 Then changey = newdir() Else changey = newdir() * -1
        End If

        ob.Location = newpos
    End Sub

End Class