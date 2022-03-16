<?php
require("require.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table>
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <thead>

                <td><?php echo $arrayResult[$i][''] ?></td>

            </thead>

            <tr>

                <td><?php echo $arrayResult[$i][''] ?></td>
                <td><img src="<?php echo $arrayResult[$i]['Image_reference'] ?>" alt=""></td>


            </tr>
        <?php endfor;
        ?>
    </table>


    <table>
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <thead>

                <td><?php echo $arrayResult[$i][''] ?></td>

            </thead>

            <tr>

                <td style=color:aliceblue><?php echo $arrayResult[$i][''] ?></td>
                <td style=color:aliceblue><img src="<?php echo $arrayResult[$i][''] ?>" alt=""></td>


            </tr>
        <?php endfor;
        ?>
    </table>




</body>

</html>