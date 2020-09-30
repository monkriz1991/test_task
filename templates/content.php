<?php

include '../assets/config.php';
include '../assets/db.php';
include '../function_pages.php';
if (!isset($_SESSION)){session_start();$id_user=$_SESSION['id'];}else{}
	

	$data_filter = json_decode(htmlspecialchars_decode($_POST['data_filter']),true);
	$page = $_POST['page'];

	if ($page == ""){
		$str_start = 0;
		$str_end = 4;
	}else{
		$str_end = $page*4;
		$str_start = $str_end-4;
	}


	$whereString = myForeach($data_filter);


	$sql = "select tasks.*,users.name,users.email from tasks 
	left join users on users.id_user = tasks.id_user ".$whereString." order by tasks.id_tasks DESC LIMIT ".$str_start.",4"; 

	$sql_count = "select tasks.*,users.name,users.email from tasks 
	left join users on users.id_user = tasks.id_user ".$whereString." order by tasks.id_tasks DESC";

	$res_count = mysqli_query($db_connect,$sql_count);                    
	$count = mysqli_num_rows($res_count);	

	$res = mysqli_query($db_connect,$sql); 
	while($row = mysqli_fetch_array($res)){

	?>
		<div class="tasks fl-left">
			<div class="tasks-user fl-left">
				<div class="tasks-user-img fl-left" style="background-image: url('img/no_img.png')"></div>
				<div class="tasks-user-left">
					<strong><?php echo $row['name'];?></strong>
					<span><?php echo $row['email'];?></span>
				</div>
			</div>
			<div class="tasks-inf fl-left">
				<?php if($id_user=='' || $row['status'] == 'closed'){
						if ($row['status'] == 'closed') {$class_closed = 'close_tasks';}
					?>
					<strong class="tasks-status <?php echo $class_closed;?>"><?php echo $row['status'];?></strong>
				<?php }else{ ?>
					<strong class="tasks-status" data-id="<?php echo $row['id_tasks'];?>"><?php echo $row['status'];?></strong>
					<strong class="close_tasks" data-id="<?php echo $row['id_tasks'];?>">закрыть</strong>
				<?php } ?>
				<?php if($id_user==''){?>
					<p ><?php echo $row['text'];?></p>
				<?php }else{ ?>
					<p class="edit-tasks" data-id="<?php echo $row['id_tasks'];?>">
						<textarea  disabled><?php echo $row['text'];?></textarea>
						<i class="far fa-spell-check" data-id="<?php echo $row['id_tasks'];?>"></i>
					</p>
				<?php } ?>
				<span><?php echo $row['date'];?></span>
			</div>
		</div>

	<?php
		}					
	?>

		<div class="fl-left pages-block">
			<?php
				$count=$count/4;
				for($i=0;$i<$count;$i++){
					if ($page == $i+1 || $i == 0 && $page == '' ) {
						$id_page_class = 'page-b-active';
					}else{
						$id_page_class = '';
					}
			?>
				<a class="<?php echo $id_page_class;?>" data-pages="<?php echo $i+1; ?>"  onclick="new_page(this);">
		     		<b><?php echo $i+1 ;?></b>
		     	</a>   
			<?php	
				}
			?>
		</div>