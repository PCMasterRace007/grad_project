<?php
$sql2 = "SELECT email, name, contatn FROM business";
$ret2 = $db->query($sql2);
while ($row2 = $ret2->fetchArray(SQLITE3_BOTH)) {
?>
<div class="w3-responsive">
    <div class="w3-container">
        <table class="w3-table-all txt">
            <tr class="w3-fc txtb">
                <th>
                    Business Name
                </th>
                <th>
                    Business Email
                </th>
                <th>
                    Business Contact
                </th>
                <th>
                    Remove Business
                </th>
            <tr class="w3-fc">
                <td>
                    <?php echo $row2['name'] ?>
                </td>
                <td>
                    <?php echo $row['email'] ?>
                </td>
                <td>
                    <?php echo $row2['contact'] ?>
                </td>
                <td>
                    <button class="w3-button txt w3-red">Remove</button>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php } ?>