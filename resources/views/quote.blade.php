@extends("layout")




@section("style")
    <link href="https://fonts.googleapis.com/css?family=Ranga" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/mainPage.css">
    <style type="text/css">
	    @font-face {
	    font-family: "iransans";
	    src: css/fonts/iransans.woff2;
		}
		.jumbotron{font-family: "iransans";}
		p{padding: 0px;margin-bottom: 0px;}
    </style>
@endsection



@section("content")

    <div class="jumbotron vertical-center ">
	    <div class="container" style="position: relative;" >
	      	<img src="img/2.jpg">
	        <p style="position: absolute;top: 78px;left:90px;">
	        	<span style="background: rgb(0, 0, 0);background: rgba(0, 0, 0, 0.7);padding: 10px; ">
		        	به این فکر کنی چجوری برگردی؟ 
			    </span>
	        </p>
	        <p style="position: absolute;top: 300px;">
	        	
		        	<small style="padding-left: 100px;margin-bottom: 10px;">m-gh.info </small>
			    
	        </p>
    	</div>
      
    </div>

@endsection("content")


@section("footer")

    
@endsection