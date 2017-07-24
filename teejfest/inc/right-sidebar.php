<aside class="right-side">
    <section class="content-header">
        <h1>
            Manage
            <small>Counter</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <form name="manageCount" method="post">
                <fieldset>
                    <div class="form-group" show-errors>
                        <label class="control-label" for="count">Total Count</label>
                        <input name="count" type="number" value="<?php echo $countValue; ?>" id="count" class="form-control" placeholder="Enter count number" required>
                    </div>
                    <div><?php echo $msg; ?></div>
                    <div class="panel-footer">
                        <button class="btn btn-oval btn-info" type="submit">Save</button>
                    </div>
                </fieldset>
            </form>​
        </div>
    </section>
</aside>