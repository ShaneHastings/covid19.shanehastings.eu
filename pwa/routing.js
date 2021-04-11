function routePage(page) {
    const navigator = document.querySelector('#navigator');
    navigator.pushPage(page);
}


var PAGES = {
    testing: 'testing.html',
    vaccines: 'vaccines.html',
    settings: 'settings.html',
};

var changePageByUrl = function() {
    var newPage;
    if (location.hash) {
        newPage = location.hash.split('#')[1];
    }

    if (PAGES[newPage]) {
        setImmediate(function() {
            document.querySelector('ons-navigator').pushPage(PAGES[newPage]);
        });
    }
}

ons.ready(function (event) {
    changePageByUrl();
    window.addEventListener('hashchange', changePageByUrl);
});