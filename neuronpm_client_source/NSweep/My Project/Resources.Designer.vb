﻿'------------------------------------------------------------------------------
' <auto-generated>
'     This code was generated by a tool.
'     Runtime Version:4.0.30319.42000
'
'     Changes to this file may cause incorrect behavior and will be lost if
'     the code is regenerated.
' </auto-generated>
'------------------------------------------------------------------------------

Option Strict On
Option Explicit On

Imports System

Namespace My.Resources
    
    'This class was auto-generated by the StronglyTypedResourceBuilder
    'class via a tool like ResGen or Visual Studio.
    'To add or remove a member, edit your .ResX file then rerun ResGen
    'with the /str option, or rebuild your VS project.
    '''<summary>
    '''  A strongly-typed resource class, for looking up localized strings, etc.
    '''</summary>
    <Global.System.CodeDom.Compiler.GeneratedCodeAttribute("System.Resources.Tools.StronglyTypedResourceBuilder", "4.0.0.0"),  _
     Global.System.Diagnostics.DebuggerNonUserCodeAttribute(),  _
     Global.System.Runtime.CompilerServices.CompilerGeneratedAttribute(),  _
     Global.Microsoft.VisualBasic.HideModuleNameAttribute()>  _
    Friend Module Resources
        
        Private resourceMan As Global.System.Resources.ResourceManager
        
        Private resourceCulture As Global.System.Globalization.CultureInfo
        
        '''<summary>
        '''  Returns the cached ResourceManager instance used by this class.
        '''</summary>
        <Global.System.ComponentModel.EditorBrowsableAttribute(Global.System.ComponentModel.EditorBrowsableState.Advanced)>  _
        Friend ReadOnly Property ResourceManager() As Global.System.Resources.ResourceManager
            Get
                If Object.ReferenceEquals(resourceMan, Nothing) Then
                    Dim temp As Global.System.Resources.ResourceManager = New Global.System.Resources.ResourceManager("neuronPM.Resources", GetType(Resources).Assembly)
                    resourceMan = temp
                End If
                Return resourceMan
            End Get
        End Property
        
        '''<summary>
        '''  Overrides the current thread's CurrentUICulture property for all
        '''  resource lookups using this strongly typed resource class.
        '''</summary>
        <Global.System.ComponentModel.EditorBrowsableAttribute(Global.System.ComponentModel.EditorBrowsableState.Advanced)>  _
        Friend Property Culture() As Global.System.Globalization.CultureInfo
            Get
                Return resourceCulture
            End Get
            Set
                resourceCulture = value
            End Set
        End Property
        
        '''<summary>
        '''  Looks up a localized resource of type System.Drawing.Bitmap.
        '''</summary>
        Friend ReadOnly Property dirona_abolineata() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("dirona_abolineata", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized resource of type System.Drawing.Bitmap.
        '''</summary>
        Friend ReadOnly Property melibe() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("melibe", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized string similar to /* load the standard hoc files we need */
        '''load_file(&quot;stdlib.hoc&quot;)
        '''load_file(&quot;family.hoc&quot;)
        '''load_file(&quot;shapebox.hoc&quot;)
        '''load_file(&quot;pointbsr.hoc&quot;, &quot;PointBrowser&quot;)
        '''load_file(&quot;wingroup.hoc&quot;)
        '''load_file(&quot;stdrun.hoc&quot;)
        '''load_file(&quot;inserter.hoc&quot;)
        '''load_file(&quot;pointman.hoc&quot;)
        '''print &quot;WINSWEEP - INIT - standard libraries opened&quot;
        '''
        '''/* load and initialize the sweep data structures */
        '''chdir(winsweepdirectory)
        '''load_file(&quot;sweeptypes.hoc&quot;)
        '''objref plist
        '''plist = new ParameterList()
        '''print &quot;WINSWEEP - INIT - parameter ty [rest of string was truncated]&quot;;.
        '''</summary>
        Friend ReadOnly Property sweep() As String
            Get
                Return ResourceManager.GetString("sweep", resourceCulture)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized string similar to begintemplate Parameter
        '''	public name, type, ubound, level, value, base, increment
        '''
        '''	strdef name, type
        '''	objref vallist
        '''
        '''	proc init() {
        '''		level = 0
        '''		name = $s1
        '''		type = $s2
        '''		if (strcmp(type, &quot;list&quot;) == 0) {
        '''			vallist = new Vector()
        '''			vallist.append($o3)
        '''			ubound = vallist.size() - 1
        '''			return
        '''		}	
        '''
        '''		if (strcmp(type, &quot;exp&quot;) == 0) {
        '''			ubound = $3
        '''			expbase = $4
        '''			expstart = $5
        '''			return
        '''		}
        '''
        '''		ubound = $3
        '''		slope = $4
        '''		intercept = $5
        '''	}
        '''
        '''	func increment() {
        '''		level = leve [rest of string was truncated]&quot;;.
        '''</summary>
        Friend ReadOnly Property sweeptypes() As String
            Get
                Return ResourceManager.GetString("sweeptypes", resourceCulture)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized resource of type System.Drawing.Bitmap.
        '''</summary>
        Friend ReadOnly Property title() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("title", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized resource of type System.Drawing.Bitmap.
        '''</summary>
        Friend ReadOnly Property Tochuina() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("Tochuina", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
        
        '''<summary>
        '''  Looks up a localized resource of type System.Drawing.Bitmap.
        '''</summary>
        Friend ReadOnly Property tritonia() As System.Drawing.Bitmap
            Get
                Dim obj As Object = ResourceManager.GetObject("tritonia", resourceCulture)
                Return CType(obj,System.Drawing.Bitmap)
            End Get
        End Property
    End Module
End Namespace
