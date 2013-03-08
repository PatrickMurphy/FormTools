<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Form Tools | Admin</title>
<link href="style.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<div class="container">
  <header>
  	<a href="#"><img src="images/logo.jpg" alt="Form Tools" width="273" height="85" /></a>
  </header>
  <div id="topbar"></div>
  <div class="sidebar1">
    <nav>
      <ul>
        <li class="current"><a href="#">Home</a></li>
        <li><a href="#">Options</a></li>
        <li><a href="#">Create form</a></li>
        <li><a href="#">Edit form</a></li>
        <li><a href="#">Data</a></li>
        <li><a href="#">Statistics</a></li>
      </ul>
    </nav>
  <!-- end .sidebar1 --></div>
  <article class="content">
  	<div class="error" style="margin-left:15px"><h2>Error:</h2><p>Error was this and that. Next time do this!</p></div>
    <div class="success" style="margin-left:15px"><h2>Error:</h2><p>Error was this and that. Next time do this!</p></div>
    <h1>Home</h1>
    <section>
     <h2>Option 1</h2>
  	 <p>Description</p>
     <table>
     	<tr><th>Heading 1</th><th>Heading 2</th><th>Heading 3</th></tr>
        <tr><td>Data 1</td><td>data 2</td><td>data 3</td></tr>
        <tr><td>Data 1</td><td>data 2</td><td>data 3</td></tr>
        <tr><td>Data 1</td><td>data 2</td><td>data 3</td></tr>
        <tr><td>Data 1</td><td>data 2</td><td>data 3</td></tr>
        <tr><td>Data 1</td><td>data 2</td><td>data 3</td></tr>
     </table>
     <br />
     <form>
     	<input type="text" placeholder="Username" /><br />
		<input type="password" placeholder="Password" /><br />
        <input type="submit" value="Login" />
     </form>
     <br />
     <div class="form">
         <form>
            <label>Name:</label><input type="text" /><br />
            <label>Question:</label><input type="text" /><br />
            <input type="submit" value="Submit" />
         </form>
     </div>
    </section>
    <!-- end .content --></article>
  <footer>
    <p>Form tools &copy; Patrick Murphy Webdesign. 2012.</p>
  </footer>
  <!-- end .container --></div>
</body>
</html>