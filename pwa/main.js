document.addEventListener('init', function(event) {

    var page = event.target;

    if (page.id === 'page1') {
        page.querySelector('#push-button').onclick = function() {
            document.querySelector('#myNavigator').pushPage('page2.html', {data: {title: 'Page 2'}});
        };
    } else if (page.id === 'page2') {
        page.querySelector('ons-toolbar .center').innerHTML = page.data.title;
    }

});



/** Alert message about daily second dose / fully vax. count figures */
function secondDoseInfoAlert() {
    ons.notification.alert({
        message: 'This includes people who have received one-dose vaccines (e.g. Johnson & Johnson), as they are considered fully vaccinated after one dose.',
        title: 'Second dose data'
    });
};

function cookieWarning() {

    var userCookie = check_cookie_name("theme");

    ons.notification.alert({
        message: 'By default this site will use the iOS style layout. To remember your preference for an alternative, the page will place a cookie in your browser so that you dont have to reselect this option every time.' +
            'Your current preference is: ' + userCookie,
        title: 'Notice about cookies'
    });
};

/** jQuery call to update Laboratory Testing Data */
function updateTestingData(){
    ons.notification.toast('Fetching latest data...', { timeout: 2000, animation: 'ascend' });
    $.getJSON('/api/swabs/json/', function(testingData) {

        // Format the date in format l, F jS Y
        var swabDate = testingData.date;
        var longDateString = moment(swabDate).format('dddd, MMMM Do YYYY');

        $('#testingDataDate').html(longDateString);
        $('#positiveTests').html(numberFormat(testingData.positive_swabs));
        $('#positivityRate').html(testingData.positivity_rate);
        $('#totalTests').html(numberFormat(testingData.swabs_24hr));
        $('#positivityRate7Day').html(testingData.positivity_rate_7day);

        // Update 'last checked' time.
        var today = new Date();
        var time = today.toLocaleTimeString();
        document.getElementById("curTime").innerText = time;
    });
}

/** Format numbers to add a thousands separator */
function numberFormat(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


/** Set cookies for page theme */
function setPageTheme(theme){
    var expiryDate = new Date();
    var time = expiryDate.getTime();
    var expireTime = time + 100000*72000;
    expiryDate.setTime(expireTime);
    document.cookie = "theme=" + theme + "; expires=" + expiryDate.toUTCString() + "; path=/pwa/";
    window.location.reload(true);
}
/** Check what cookies are set and define the theme based on that. If none set, default to iOS layout.
 * Onsen UI actually does do detection of device and defaults to that, but I am purposely countering this
 * as I'm not a fan of the Material layout they've got going on. */
function themeChecker(){

    var cookieTheme = check_cookie_name("theme");
    var android = "android";
    var ios = "ios";

    if (cookieTheme == android){
        ons.platform.select('android');
    } else if (cookieTheme == ios){
        ons.platform.select('ios');
    } else {
        ons.platform.select('ios');
    }

}

function check_cookie_name(name)
{
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) {
        return match[2];
    }
    else{
        console.log('--something went wrong---');
    }
}