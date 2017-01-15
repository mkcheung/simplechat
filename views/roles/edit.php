
<h1>Edit Role</h1>

<form action="/roles/<?php echo $data['role']['id'] ?>" method="POST">
  <input type="text" name="role[name]" value="<?php _h($data['role']['name']) ?>"/>
  <input type="hidden" name="_method" value="patch"/>
  <input type="submit" value="Save"/>
</form>
