<?php
function getAge ($dob){
    $bday=new DateTime($dob);
    $today=new DateTime(date ('m.d.y'));
    if($bday>$today){
        return 'You are not born yet';
    }
    $diff=$today->diff($bday);
    return 'Your Current Age is: '.$diff->y. ' Years, '.$diff->m. ' months, '.$diff->d. 'days';
}
?>
<h1>Calculating Age</h1>
<hr>
<div>
    <form>
        <div>
            <label>Date of Birth</label>
            <input type="date" name="dob" value="<?php echo (isset ($_GET ['dob']))? $_GET ['dob']:'';?>">
            <input type="submit" value="Calculate Age">
        </div>
    </form>
    <?php
    if (isset ($_GET ['dob']) && $_GET ['dob']!= ''){
    ?>
    <div>
        <?php
        echo getAge($_GET ['dob']);
        ?>
    </div>
    <?php } ?>
</div>