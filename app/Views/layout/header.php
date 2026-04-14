<header class="d-flex justify-content-end align-items-center py-2 px-3" id="header">
    <div class="profile">
        <div class="profile_img d-flex align-items-center gap-2 position-relative">
            <img src="https://ui-avatars.com/api/?name=<?= session()->get('name') ?>&background=random" alt="Profile Image" class="rounded-circle" width="40" height="40">
            <span class="profile_name"><?= session()->get('name') ?></span>
            <div id="profile_dropdown" class="bg-light p-2 d-none">
                <a href="/">Profile</a>
                <a href="/logout">Logout</a>
            </div>
        </div>
    </div>
</header>
<script>
    // $(document).ready(function(){
        $(".profile").hover(function(){
            $("#profile_dropdown").toggleClass('d-none');
        });
    // });
</script>