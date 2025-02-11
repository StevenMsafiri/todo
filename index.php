<?php 
require 'db_conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>To-Do list</title>
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="">
                <input type="text"
                    name="title"
                    placeholder="This field is required"  id="text"/>
                <button type="submit" class="blue-btn">Add &nbsp; <span>&#43;</span></button>
            </form>
        </div>
        <?php
        $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-section">
            <?php
            if($todos->rowCount() === 0){?>
            <div class="empty">
                <img src="/img/loading.gif" alt="A Loading giphy" width="100%"/>
            </div>
       <?php } ?> 
        
    <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="todo-item">
            <span id="<?php echo $todo["id"];?>">
                <button class="remove-todo">x</button></span>

            <?php if($todo["checked"]){?>
                <input type="checkbox" 
                       class="check-box"
                       checked/>

                <h2 class="checked"><?php echo $todo["title"]?></h2>
            
            <?php }else{?>
                <input type="checkbox" 
                       class="check-box"/>

                <h2><?php echo $todo["title"]?></h2>
            <?php }?>
                <br>
                <small>created: <?php echo $todo["date_time"]?></small>
        </div>

        <?php }?>
    

    </div>
    </div>
</body>

</html>