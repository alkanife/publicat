//
// USER FOLLOWS
//
const followingButton = document.getElementById('following-button');
const followButton = document.getElementById('follow-button');

if (followButton !== null) {
    followButton.addEventListener('click', () => {
        api_POST('follow/', { username: userProfileName}).then((data) => {
            if (data.success) {
                createNotification(followSuccess, 'success');
                followButton.style.display = 'none';
                followingButton.style.display = 'flex';
            } else {
                reset();
                createNotification(followError, 'error');
            }
        }).catch((err) => {
            reset();
            createNotification(followError, 'error');
        });
    })
}

if (followingButton !== null) {
    followingButton.addEventListener('click', () => {
        api_POST('unfollow/', { username: userProfileName}).then((data) => {
            if (data.success) {
                createNotification(unfollowSuccess, 'success');
                followingButton.style.display = 'none';
                followButton.style.display = 'flex';
            } else {
                reset();
                createNotification(unfollowError, 'error');
            }
        }).catch((err) => {
            reset();
            createNotification(unfollowError, 'error');
        });
    })
}