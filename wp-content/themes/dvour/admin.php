<h1>d`Vour theme Customize</h1>
<br><br>
<h2>Include city`s</h2>
<form action="" method="post">
<label>
    City<br>
    <input name="city" type="text" id="newcity" placeholder="Select the City" required>
</label>
<input type="submit" value="Enter city">
</form>
<?php
global $wpdb;
if(isset($_POST['city']))
{
    $res = $wpdb->get_results("SELECT `city_name` FROM `city` WHERE `city_name`='".$_POST['city']."'");
    if(count($res)==0) {

        $wpdb->insert('city', array('city_name' => $_POST['city']));
    }
    else{
        echo "<h3 class='alert'>You already have that city in your list</h3>";
    }
}
$city_list = $wpdb->get_results("SELECT `city_name` FROM `city`");
?>
<table id="city_list_table">
<?php
$i=1;
foreach($city_list as $city){
    echo "<tr><th>".$i."</th><td class='city_name'>".$city->city_name."</td><td class='remove_city remove_".$i."'>X</td></tr>";
    $i++;
}
?>
</table>
<script>
    var adminajax = "<?php echo get_site_url();?>/wp-admin/admin-ajax.php";
jQuery('.remove_city').click(function(){
   data = {
       action: 'remove_city',
       name: jQuery(this).parent().find('.city_name').html()
   };
jQuery.post(adminajax, data, function(res){
console.log(res);
    location.reload();
})
});
</script>
<style>
    .remove_city{
        cursor:pointer;
    }
    #city_list_table {
        font-family: DINProMedium;
        font-size: 16px;
        font-weight: 600;
    }
    #city_list_table th {
        width:100px;
        padding: 20px 10px;
    }
    #city_list_table td:first-of-type {
        width:200px;
    }
    #city_list_table td:nth-of-type(2){
        padding-left: 10px;
        padding-right: 10px;
    }
    #city_list_table tr{
        padding: 10px 0;
    }
    #city_list_table tr:nth-of-type(2n+1)
    {
        background: #ccc;
    }
</style>


<h2>Include Team Members Info</h2>
<form action='' method='post' enctype="multipart/form-data">
<label>Select member</label><br>
<select name='member_id'>
<option value="1">Member 1</option>
<option value="2">Member 2</option>
<option value="3">Member 3</option>
<option value="4">Member 4</option>
</select><br>
<label class='member_label'>Name</label><br>
<input type="text" name='member_name' class='member_text' required><br>
<label class='member_label'>Role</label><br>
<input type="text" name='member_role' class='member_text' required><br>
<label class='member_label'>Description </label><br>
<textarea rows=5 name="member_description" class='member_text' required></textarea><br><br>
<label>Input member pic</label>
<input type="file" name="member_pic"><br><br>
<label class='member_label'>Facebook</label><br>
<input type="text" name='member_facebook' class='member_text'><br>
<label class='member_label'>Twitter</label><br>
<input type="text" name='member_twitter' class='member_text'><br>
<label class='member_label'>Instagram</label><br>
<input type="text" name='member_instagram' class='member_text'><br>
<label class='member_label'>Pinterest</label><br>
<input type="text" name='member_pinterest' class='member_text'><br>
<input type='submit' value='SAVE'>
</form>
<?php
if(isset($_POST['member_name']))
{
$id = $_POST['member_id'];
$name = $_POST['member_name'];
$role = $_POST['member_role'];
$desc = $_POST['member_description'];
$uploaddir = get_stylesheet_directory()."/img/";
$img = $uploaddir.basename($_FILES['member_pic']['name']);
if (move_uploaded_file($_FILES['member_pic']['tmp_name'], $img)) {
$pic = get_stylesheet_directory_uri()."/img/".$_FILES['member_pic']['name'];
} else { echo "File Upload Error"; $pic='none';}
$face = $_POST['member_facebook'];
$twit = $_POST['member_twitter'];
$pint = $_POST['member_pinterest'];
$insta = $_POST['member_instagram'];
print_r($_POST);
$where = array('id'=>$id);
$data = array(
'name' => $name,
'role' => $role,
'descr' => $desc,
'pic' => $pic,
'face' => $face,
'twit' => $twit,
'insta' => $insta,
'pint' => $pint
);
global $wpdb;
$wpdb->update('members', $data, $where);

echo "<pre>";
echo $wpdb->last_query;
print_r($data);
print_r($where);
/*$wpdb->query("UPDATE `members` SET `name`='".$name."', `role`='".$role."', `descr`='".$desc."', `pic`='".$img."', `face`='".$face."', `twit`='".$twit."', `insta`='".$insta."', `pint`='".$pint."' WHERE `id`='".$id."'");*/
}
?>
<style>
.member_text {
width:300px;
}
.member_label {
font-size:16px;
font-weight:bold;
}
</style>
