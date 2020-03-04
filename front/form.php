<?php

?>
<form action="">
    <fieldset>
        <legend>Compare two URLs</legend>
        <p>
            <label for="prismic">Prismic URL</label>
            <input type="url" name="prismic" id="prismic" value="<?= $prismicUrl; ?>">
        </p>
        <p>
            <label for="censhare">Censhare URL</label>
            <input type="url" name="censhare" id="censhare" value="<?= $censhareUrl; ?>">
        </p>
        <p>
            <input type="submit" value="OK">
        </p>
    </fieldset>
</form>
