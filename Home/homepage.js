// prevent back button of browser
(function () {
    if (window.history && window.history.pushState) {
        window.history.pushState('', null, './homepage.php');
        window.onpopstate = function () {
            window.history.pushState('', null, './homepage.php');
        };
    }
})();
