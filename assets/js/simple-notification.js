document.addEventListener('DOMContentLoaded', function () {
    const successNotification = document.querySelector('.success-notification');
    if (successNotification) {
        setTimeout(function () {
            successNotification.classList.add('show');
            setTimeout(function () {
                successNotification.classList.remove('show');
            }, 3000); // 3 giây
        }, 100);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const errorNotification = document.querySelector('.error-notification');
    if (errorNotification) {
        setTimeout(function () {
            errorNotification.classList.add('show');
            setTimeout(function () {
                errorNotification.classList.remove('show');
            }, 3000); // 3 giây
        }, 100);
    }
});