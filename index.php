<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    	.rowPadding{
    		padding-top: 3px;
    		padding-bottom: 3px;
    	}
    	.tagHighlighting{
    		background-color: #EDE275;
    	}
    	.pageSource{
		    overflow-y:scroll;
		    max-height: 600px;
		}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <title>Coding Exercise</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container bs-docs-container">
	  	<h4>Application Engineer Coding Exercise</h4>
    	<div class="row rowPadding">
    		<div class="col-md-12" role="main">
		    	<div class="input-group">
		    		<span class="input-group-addon" id="basic-addon3">Enter URL:</span>
		    		<input type="text" class="form-control" id="url" aria-describedby="basic-addon3" name="url" onkeydown = "if (event.keyCode == 13) document.getElementById('getPageSource').click()"/>
		    		<span class="input-group-btn">
    					<button class="btn btn-default" type="button" id="getPageSource">Go!</button>
  					</span>
		    	</div>
			</div>
		</div>
		<div class="row rowPadding">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">Page Source Summary:</div>
					<table class="table" id="tagResults">
						<thead>
							<tr>
								<th scope="row">Tag</th>
								<th>Tag Count</th>
							</tr>
						</thead>
						<tbody id="tagResultsBody">
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-9">
				<figure class="highlight">
					<pre id="pageSource" class="pageSource"></pre>
				</figure>
			</div>
		</div>
		<div class="row rowPadding">
			
		</div>
	</div>
	<script type="text/javascript">
    	$(document).ready(function(){
    		$("#getPageSource").on( "click" , function() {
    			$("#tagResultsBody tr").remove();
    			$("#pageSource").html("Loading...");
    			$.ajax({
    				type: "POST",
    				url: "./pageFetch.php",
    				data: { url: $("#url").val() },
    				success: function(result){
    					var html = $.parseHTML($.trim(result.sourceCode));
    					$("#tagResultsBody tr").remove();
    					$("#pageSource").html(html);
    					$("#tagResultsBody").append(result.tableContents);
    					if($("#pageSource").is(":empty") || result.sourceCode == ''){
    						$("#pageSource").html("Sorry, there was a problem loading the sites page source.  Please verify url and try again.");
    					}
    				},
    				dataType: "json",
    			});
    		});
    	});
    	//Tag Highlighting
    	//input: tag name
    	function highlight(id) {
   			var tagSearch1 = "&lt;"+id+" ";
   			var tagSearch2 = "&lt;/"+id+"&gt;";
   			var tagSearch3 = "&lt;"+id+"&gt;";
    		var regex1 = new RegExp(tagSearch1,"gi");
    		var regex2 = new RegExp(tagSearch2,"gi");
    		var regex3 = new RegExp(tagSearch3,"gi");
    		var replace1 = "<span class='tagHighlighting'>&lt;"+id+"</span> ";
    		var replace2 = "<span class='tagHighlighting'>&lt;/"+id+"&gt;</span>";
    		var replace3 = "<span class='tagHighlighting'>&lt;"+id+"&gt;</span>";
    		$('#pageSource').each(function(){
    			$(this).html($(this).html().replace(regex1, replace1));
    			$(this).html($(this).html().replace(regex2, replace2));
    			$(this).html($(this).html().replace(regex3, replace3));
    		});
		}
    </script>
  </body>
</html>
