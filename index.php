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
            <form action="app/add.php" method="POST" autocomplete="off">
                <?php if (isset($_GET['mess']) && $_GET['mess'] == "error") { ?>
                    <input type="text"
                        name="title" style="border-color: #ff6666;"
                        placeholder="This field is required" id="text" />
                    <button type="submit" class="blue-btn">Add &nbsp; <span>&#43;</span></button>
                <?php   } else { ?>
                    <input type="text"
                        name="title"
                        placeholder="What you need to do?" id="text" />
                    <button type="submit" class="blue-btn">Add &nbsp; <span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php
        $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
        ?>
        <div class="show-section">
            <?php
            if ($todos->rowCount() === 0) { ?>
                <div class="empty">
                    <img src="./img/giphy.gif" alt="A loading giphy" width="100%" />
                </div>
            <?php } ?>

            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo["id"]; ?>" 
                    class="remove-todo">x</span>

                    <?php if ($todo["checked"]) { ?>
                        <input type="checkbox"
                            class="check-box"
                            data-todo-id="<?php echo $todo["id"]; ?>"
                            checked />

                        <h2 class="checked"><?php echo $todo["title"]; ?></h2>

                    <?php } else { ?>
                        <input type="checkbox"
                            data-todo-id="<?php echo $todo["id"]; ?>"
                            class="check-box" />

                        <h2><?php echo $todo["title"]; ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $todo["date_time"]; ?></small>
                </div>

            <?php } ?>


        </div>
    </div>

    <script src="./js/jquery-3.7.0.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-todo').click(function(){
                const id = $(this).attr('id');
        
                $.post("app/remove.php",
                {
                    id: id
                },
                (data) => {
                    if(data){
                        $(this).parent().hide(600);
                    }
                }
                );
        });

        $(".check-box").click(function(e){
            const id = $(this).attr('data-todo-id');
            
            $.post('app/checked.php',
            {
                id: id
            },
            (data) => { 
                if(data != 'error'){
                    const h2 =$(this).next();
                    if(data === '1'){
                        h2.removeClass('checked');
                    }else{
                        h2.addClass('checked');
                    }
                }
            })
        });
    });

    </script>

</body>

</html>