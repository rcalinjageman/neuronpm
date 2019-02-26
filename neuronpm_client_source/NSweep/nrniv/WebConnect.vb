Module WebConnect
    Public Function GetPageHTML(ByVal URL As String, Optional ByVal TimeoutSeconds As Integer = 20) As String
        ' Retrieves the HTML from the specified URL,
        ' using a default timeout of 20 seconds
        ' lifted from http://www.developer.com/net/vb/article.php/3113371
        ' by Karl Moore

        Dim objRequest As Net.WebRequest
        Dim objResponse As Net.WebResponse
        Dim objStreamReceive As System.IO.Stream
        Dim objEncoding As System.Text.Encoding
        Dim objStreamRead As System.IO.StreamReader

        Try
            ' Setup our Web request
            objRequest = Net.WebRequest.Create(URL)
            objRequest.Timeout = TimeoutSeconds * 1000
            ' Retrieve data from request
            objResponse = objRequest.GetResponse
            objStreamReceive = objResponse.GetResponseStream
            objEncoding = System.Text.Encoding.GetEncoding( _
                "utf-8")
            objStreamRead = New System.IO.StreamReader( _
                objStreamReceive, objEncoding)
            ' Set function return value
            GetPageHTML = objStreamRead.ReadToEnd()
            ' Check if available, then close response
            If Not objResponse Is Nothing Then
                objResponse.Close()
            End If
        Catch problem As Exception
            ' Error occured grabbing data, return the problem
            Return problem.Message
        End Try
    End Function

    Public Function UploadFile(ByVal uploadfilename As String, ByVal url As String, ByVal fileFormName As String, ByVal contenttype As String, ByVal querystring As System.Collections.Specialized.NameValueCollection, Optional ByVal TimeoutSeconds As Integer = 20) As String
        ' uploads a file to the webserver with a timeout of 20s

        'ensure fileform name is correct
        If (fileFormName Is Nothing) OrElse (fileFormName.Length = 0) Then
            fileFormName = "workfile"
        End If

        'ensure content type has been given
        If (contenttype Is Nothing) OrElse (contenttype.Length = 0) Then
            contenttype = "application/octet-stream"
        End If

        'record querystring into url query
        Dim postdata As String
        postdata = "?"
        If Not (querystring Is Nothing) Then
            For Each key As String In querystring.Keys
                postdata += key + "=" + querystring.Get(key) + "&"
            Next
        End If

        Try
            Dim uri As Uri = New Uri(url + postdata)

            'encode initial boundary
            Dim boundary As String = "----------" + DateTime.Now.Ticks.ToString("x")
            Dim webrequest As System.Net.HttpWebRequest = CType(webrequest.Create(uri), System.Net.HttpWebRequest)
            webrequest.ContentType = "multipart/form-data; boundary=" + boundary
            webrequest.Method = "POST"
            webrequest.Timeout = TimeoutSeconds * 1000
            'start building content
            Dim sb As System.Text.StringBuilder = New System.Text.StringBuilder
            sb.Append("--")
            sb.Append(boundary)
            sb.Append("" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "")
            sb.Append("Content-Disposition: form-data; name=""")
            sb.Append(fileFormName)
            sb.Append("""; filename=""")
            sb.Append(System.IO.Path.GetFileName(uploadfilename))
            sb.Append("""")
            sb.Append("" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "")
            sb.Append("Content-Type: ")
            sb.Append(contenttype)
            sb.Append("" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "")
            sb.Append("" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "")
            Dim postHeader As String = sb.ToString
            Dim postHeaderBytes As Byte() = System.Text.Encoding.UTF8.GetBytes(postHeader)
            Dim boundaryBytes As Byte() = System.Text.Encoding.ASCII.GetBytes("" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "--" + boundary + "" & Microsoft.VisualBasic.Chr(13) & "" & Microsoft.VisualBasic.Chr(10) & "")
            Dim fileStream As System.IO.FileStream = New System.IO.FileStream(uploadfilename, System.IO.FileMode.Open, System.IO.FileAccess.Read)
            Dim length As Long = postHeaderBytes.Length + fileStream.Length + boundaryBytes.Length
            webrequest.ContentLength = length
            Dim requestStream As System.IO.Stream = webrequest.GetRequestStream
            requestStream.Write(postHeaderBytes, 0, postHeaderBytes.Length)
            Dim sendBuffer(Math.Min(4096, fileStream.Length)) As Byte
            Dim bytesRead As Integer = 0
            'Dim r As New BinaryReader(fileStream)

            Do
                bytesRead = fileStream.Read(sendBuffer, 0, sendBuffer.Length)
                If bytesRead = 0 Then Exit Do
                requestStream.Write(sendBuffer, 0, bytesRead)
            Loop
            fileStream.Close()
            fileStream = Nothing
            requestStream.Write(boundaryBytes, 0, boundaryBytes.Length)
            requestStream.Flush()
            requestStream.Close()

            Dim responce As System.Net.WebResponse = webrequest.GetResponse
            Dim s As System.IO.Stream = responce.GetResponseStream
            Dim sr As System.IO.StreamReader = New System.IO.StreamReader(s)
            Return sr.ReadToEnd
        Catch connectproblem As Exception
            Return connectproblem.Message
        End Try
    End Function

    Public Function ReadNsweepMessage(ByVal inputhtml As String) As System.Collections.Specialized.NameValueCollection
        Dim messageset As New System.Collections.Specialized.NameValueCollection

        Dim messagepattern As String = "<nsweep>(?<key>(.*?))=(?<value>(.*?))</nsweep>"
        Dim findmessages As New System.Text.RegularExpressions.Regex(messagepattern)
        Dim messages As System.Text.RegularExpressions.MatchCollection = findmessages.Matches(inputhtml)

        Dim i As Integer
        For i = 0 To messages.Count - 1
            messageset.Add(messages(i).Groups("key").Value, messages(i).Groups("value").Value)
        Next

        Return messageset

    End Function

    Public Function Query_String(ByVal params As System.Collections.Specialized.NameValueCollection) As String
        Dim postdata As String
        postdata = "?"
        If Not (params Is Nothing) Then
            For Each key As String In params.Keys
                postdata += key + "=" + params.Get(key) + "&"
            Next
        End If
        Return postdata
    End Function
End Module
