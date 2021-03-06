<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	
	<title>Stack Exchange</title>
	<link rel="StyleSheet" href="css/style.css" type="text/css">
	<script src="js/script.js"></script>

	<?php

		$id = $_GET["id"];
		
		include 'dbfunctions.php';
		$conn=ConnectToDatabase();
		$question = GetQuestion($id);
		$answer_result = GetAllAnswers($id);
		$count_answer = mysqli_num_rows ($answer_result);
    		
	?>

	

</head>



<body>
<div id="header">
	<h1> <a href ="question-list.php" style="color:#000"> Simple Stack Exchange </a> </h1>
</div>

<div class = "container">
	<div class="boxarea">
		<h2> <?php echo $question["question_topic"] ?> <hr> </h2>
	
		<div class="vote">
			<div class="arrow-up" onclick="vote(<?php echo $question['question_id'] ?>, 'question', 'up');"></div>
			<h3> <div id="question-vote"><?php echo $question["question_vote"] ?> </div></h3>
			<div class="arrow-down" onclick="vote(<?php echo $question['question_id'] ?>, 'question', 'down');"></div>
		</div>

		<div class="question-page-content">
			<p> <?php echo $question["question_content"] ?> </p>
		</div>

		<div class="edit-delete">
			<p> asked by <b><?php echo $question["question_name"] ?></b><br>
				<?php echo $question["question_email"] ?> at <?php echo $question["question_date"] ?> | <a href=ask-question.php?edit=<?php echo $question['question_id']?> style="color:#FFA500"> edit </a> | <a href="#" onclick="validateDelete(<?php echo $question['question_id'] ?>);" style="color:#FF0000"> delete </a> </p>
		</div>
	</div>

	<?php
		if($count_answer==0) {
			echo '<div class="boxarea"> <h2> 0 Answers <hr> </h2> </div>';
		}
		else {
			 echo '<h2>'; 
			 echo $count_answer; 
			 echo' Answers <hr> </h2>';
			 while($row = mysqli_fetch_assoc($answer_result)) {
			?>
				<div class="boxarea">
					
	
					<div class="vote">
						<div class="arrow-up" onclick="vote(<?php echo $row['answer_id'] ?>, 'answer', 'up');"></div>
						<h3> <div id="answer-vote-<?php echo $row['answer_id'] ?>"> <?php echo $row["answer_vote"] ?> </div> </h3>
						<div class="arrow-down" onclick="vote(<?php echo $row['answer_id'] ?>, 'answer', 'down');"></div>
					</div>

					<div class="question-page-content">
						<p> <?php echo $row["answer_content"]  ?> </p>
					</div>

					<div class="edit-delete">
						<p> answered by <b> <?php echo $row["answer_name"] ?></b><br>
							<?php echo $row["answer_email"] ?> at <?php echo $row["answer_date"] ?> </p>
					</div>
				</div>
				<br><hr>
				<?php
			}
		}
	?>

	<br>

	<h3> Your Answer </h3>
	<form method="POST" name="Form" action="add-answer.php?id=<?php echo $id ?>" onsubmit="return validateFormAnswer()">
		<input type="text" name="answer_name" id="answer_name" placeholder="Name">
		<br>
		<input type="text" name="answer_email" id="answer_email" placeholder="Email">
		<br> 
		<textarea name="answer_content" id="answer_content" rows="15" placeholder="Content"></textarea>
		<br>
		<input type="submit" id="submit_answer" name="submit_answer" value="Post">
	</form>

</div>

</body>
</html>
