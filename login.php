<div class="masuk">
    <div class="page-header">
        <h1>Sistem Pakar Penyakit Tebu</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia quos voluptas quis tempora repellendus et quia cum. Aliquid id accusamus in deleniti, dolores et rerum? Voluptates odit nulla eveniet laudantium!</p>
    </div>
    <div class="row">
        <div class="col">
            <?php if ($_POST) include 'aksi.php'; ?>
            <form class="form-signin" action="?m=login" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Username" name="user" autofocus />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="pass" />
                </div>
                <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-log-in"></span> Masuk</button>
            </form>
        </div>
    </div>
</div>