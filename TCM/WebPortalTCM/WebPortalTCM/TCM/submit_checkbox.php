<?php

// connect to DB here
$result = mysql_query("SELECT id, name, checked FROM things");
$answers = Array();
while ($row = mysql_fetch_assoc($result))
{
    $checked = isset($_POST['cb_' + $row['id']]);
    $answers[$row['id']] = $checked;
}

// update your database here using $answers
foreach ($answers as $id => $checked)
{
    $query = "REPLACE INTO UserAnswers SET user_id=5, list_id=" . $id . ", checked=";
    if($checked)
        $query .= "1";
    else
        $query .= "0";
    mysql_query($query);
}