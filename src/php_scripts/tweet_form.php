<h5 style="margin-top:10px">Home</h5>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <textarea name="tweet" style="width: 100%; max-width: 100%;" placeholder="What's happening?"></textarea>
    <br/>
    <div style='display:flex;'>
        <input type="file" name="file" accept="image/*"/>
        <div style='margin-left: auto;'>
            <input type="submit" name="submit" value="Tweet" />
        </div>
    </div>
</form>



