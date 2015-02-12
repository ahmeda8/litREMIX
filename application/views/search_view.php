<?php echo doctype('html5');?>
<head>
<title>Search Songs</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
<script src="http://popcornjs.org/code/dist/popcorn-complete.js"></script>
<script>
         document.addEventListener( "DOMContentLoaded", function() {
 
           var popcorn = Popcorn( "#ourvideo" );
 
           popcorn.footnote({
             start: 2,
             end: 5,
             target: "footnote",
             text: "Pop!"
           });
 
         }, false );
</script>
</head>
<body>
<div class="container-fluid">
    <div class="navbar">
    <div class="navbar-inner">
		<a class="brand" href="#">litRemix</a>
		<ul class="nav">
		<li class="<?php echo ($type=="search")?"active":"" ?>"><a href="http://artistsforliteracy.org/mobile/index.php/search">Search</a></li>
		<li class="<?php echo ($type=="login")?"active":"" ?>"><a href="http://artistsforliteracy.org/mobile/index.php/search/login">Login</a></li>
		<li class="<?php echo ($type=="upload")?"active":"" ?>"><a href="http://artistsforliteracy.org/mobile/index.php/search/upload/view">Upload</a></li>
		</ul>
    </div>
    </div>
	<?php if($type=="search"):?>
	
	<form action="http://artistsforliteracy.org/mobile/index.php/search/result/view" method="POST" class="form-search">
		<input type="text" name="book" class="input-medium search-query">
		<button type="submit" class="btn">Search</button>
	</form>
	<div class="row-fluid">
	<div class="well">
	<a href="http://artistsforliteracy.org/mobile/index.php/search/result/featured">
	<h3>Featured Book</h3>
	<div class="row-fluid">
	<div class="span2">
		<img class="img-polaroid" src="http://artistsforliteracy.org/mobile/uploads/homer.jpg" alt="" style="width:100px;height:150px"/>
	</div>
	<div class="span3" >
		<h3>The Oddesey</h3>
		<h4>Homer</h4>
	</div>
	</div>
	</a>
	</div>
	</div>
	
	<div class="row-fluid">
	<div class="well">
	<a href="http://artistsforliteracy.org/mobile/uploads/07_last_temptation_odysseus.mp3">
	<h3>Featured Artist</h3>
	<div class="row-fluid">
	<div class="span2">
		<img class="img-polaroid" src="http://artistsforliteracy.org/mobile/uploads/JustinWells.jpg" alt="" style="width:100px;height:150px"/>
	</div>
	<div class="span3" >
		<h3>Justin Wells</h3>
		<h4>The Last Temptation of Odyssues</h4>
	</div>
	</a>
	</div>
	</a>
	</div>
	</div>	
	<div class="row-fluid">
	<div class="well">
	<a href="http://artistsforliteracy.org/mobile/uploads/09_calypso.mp3">
	<h3>Featured Song</h3>
	<div class="row-fluid">
	<div class="span2">
		<img class="img-polaroid" src="http://artistsforliteracy.org/mobile/uploads/Susan_Vega_Pix.jpg" alt="" style="width:100px;height:150px"/>
	</div>
	<div class="span3" >
		<h3>Calypso</h3>
		<h4>Suzanne Vega</h4>
	</div>
	</div>
	</a>
	</div>
	</div>
	<?php elseif($type=="result"): ?>
	<div class="well" >
	<div class="row">
	<div class="span2">
		<img class="img-polaroid" src="http://artistsforliteracy.org/mobile/uploads/<?php echo $book_info->cover?>" alt="" style="width:100px;height:150px"/>
	</div>
	<div class="span3" >
		<h3><?php echo $book_info->book_name?></h3>
		<h4><?php echo $book_info->book_author; ?></h4>
		<a href="http://www.amazon.com/s/ref=nb_sb_noss_1?url=search-alias%3Ddigital-text&field-keywords=<?php echo urlencode($book_info->book_name); ?>" class="btn btn-primary">Buy</a>
	</div>
	</div>
	</div>
	<div class="well"> 
	<h3>Related Songs</h3>
	<?php foreach($result_src->result() as $row): ?>
	<div class="row">
		<div class="span2">
			<a href="http://artistsforliteracy.org/mobile/uploads/<?php echo $row->track_mp3?>">
			<img class="img-polaroid" src="http://artistsforliteracy.org/mobile/uploads/<?php echo $row->coverart; ?>" alt="" >
			</a>
	</div>
	<div class="span3" >
		<h4><?php echo $row->song_name; ?></h4>
		<h5><?php echo $row->artist_name; ?></h5>
		<h5><?php echo $row->album_name; ?></h5>
		<a href="http://artistsforliteracy.org/mobile/index.php/search/questions/<?php echo $row->id_song;?>" class="btn btn-primary">Q&A</a>
		<a href="http://artistsforliteracy.org/mobile/index.php/search/lyrics/<?php echo $row->artist_name."/".$row->song_name;?>" class="btn btn-primary">Lyrics</a>
	</div>
	</div>
	<?php endforeach; ?>
	</div>
	
	<div class="well"> 
	<h3>Articles from book</h3>
	<?php foreach($articles as $atrow): ?>
	<?php //print_r($ytrow); ?>
		<?php //foreach($ytrow as $row): ?>
		
		<div class="row">
			<div class="span2">
			<h5><?php echo $atrow['article']['title'];?></h5>
			</div>
		<div class="span3" >
			<p><?php echo ellipsize($atrow['article']['content'],400,1);?></p>
		</div>
		</div>
		<?php //endforeach; ?>
	<?php endforeach; ?>
	</div>
	
	
	<div class="well"> 
	<h3>User Uploaded Songs</h3>
	<?php foreach($youtube as $row): ?>
	<?php //print_r($ytrow); ?>
		<?php //foreach($ytrow as $row): ?>
		
		<div class="row">
			<div class="span2">
				<a href="<?php echo $row['youtube']['entry']['link'][3]['href'];?>">
				<img class="img-polaroid" src="<?php echo $row['youtube']['entry']['media$group']['media$thumbnail'][0]['url']; ?>" alt="" >
				</a>
		</div>
		<div class="span3" >
			<h5><?php echo $row['youtube']['entry']['title']['$t']; ?></h5>
		</div>
		</div>
		<?php //endforeach; ?>
	<?php endforeach; ?>
	</div>
	
	
	
	<?php elseif($type=="upload"):?>
	
	<form action="http://artistsforliteracy.org/mobile/index.php/search/upload/youtube" method="POST" class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="book">Select Book</label>
		<div class="controls">
			<select name="book">
			<?php foreach($result_src->result() as $row):?>
			<option value="<?php echo $row->id_book;?>"><?php echo $row->book_name;?></option>
			<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="youtube">Youtube Link</label>
		<div class="controls">
		<input type="text" name="youtube" >
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
		<button type="submit" class="btn">Save</button>
		</div>
		
	</div>
		
	</form>
	
	<?php elseif ($type=="login"): ?>
	<div class="well"> 
	<h3>Uploaded Songs</h3>
	<?php foreach($youtube as $ytrow): ?>
	<h4><?php echo $ytrow['book'];?></h4>
	<?php //foreach($youtube['entry'] as $entry): ?>
	<?php //foreach($row['entry'] as $entry): ?>
	
	<div class="row">
		<div class="span2">
			<a href="<?php echo $ytrow['youtube']['entry']['link'][3]['href']; ?>">
			<img class="img-polaroid" src="<?php echo $ytrow['youtube']['entry']['media$group']['media$thumbnail'][0]['url']; ?>" alt="" >
			</a>
	</div>
	<div class="span3" >
		<h4><?php echo $ytrow['youtube']['entry']['title']['$t']; ?></h4>
	</div>
	</div>
	
	<?php endforeach; ?>
	<?php //endforeach; ?>
	</div>
	<?php elseif($type=="lyrics"): ?>
	<h2>Lyrics</h2>
	<div class="well">
	<p><?php echo $lyrics;?></p>
	</div>
	<?php elseif($type=="quiz"): ?>
	<h2>Quiz</h2>
	<form action="http://artistsforliteracy.org/mobile/index.php/search/savequiz" method="POST" class="form-horizontal">
		<fieldset>
		<legend><?php echo $result_src->row()->song_name; ?></legend>
		<?php foreach($result_src->result() as $row):?>
		<label><?php echo $row->question;?></label>
		<input name="<?php echo $row->id; ?>" type="text" placeholder="Answer..">
		</fieldset>
		<?php endforeach; ?>
		<button type="submit" class="btn">Submit</button>
    </form>
	
	<?php endif;?>
</div>
</body>
</html>