<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
	<div>
		<a href='<?php echo site_url('Admin/crud_areas')?>'>Areas</a> |
		<a href='<?php echo site_url('Admin/crud_points')?>'>Points</a> |
		<a href='<?php echo site_url('Admin/crud_roads')?>'>Roads</a> |
		<a href='<?php echo site_url('Admin/crud_road_points')?>'>Roads Points</a> |
		<br/>
		<span>Lookups</span>
		<a href='<?php echo site_url('Admin/crud_car_color_lookup')?>'>Car Colors</a> |
		<a href='<?php echo site_url('Admin/crud_trip_status_lookup')?>'>Trip Status</a> |
		<a href='<?php echo site_url('Admin/crud_user_type_lookup')?>'>User Types</a> |
		<a href='<?php echo site_url('Admin/crud_review_lookup')?>'>Review Types</a> |

	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
