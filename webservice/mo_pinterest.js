   

   // var redirect = window.location.origin + window.location.pathname+'?';
   var redirect = "HTTPS：//localhost/webservice/mosyaru.php";
    const ONE_WEEK = 1000 * 60 * 60 * 24 * 7;
    const POPUP_OPTIONS = 'status=no,resizable=yes,scrollbars=yes,personalbar=no,directories=no,location=no,toolbar=no,menubar=no,width=700,height=500,left=0,top=0';
    // const IG_OAUTH = 'https://instagram.com/oauth/authorize/?client_id=886a47a524e14842bb4dde8b4d2823c9&redirect_uri='+ redirect +'&response_type=token';
    // const IG_FEED = 'https://api.instagram.com/v1/users/self/media/recent/?count=12&callback=_instaFeed&access_token=';
    // const IG_COOKIE = 'ig_token';
    const PIN_APP = '4814511838437846242';
    const PIN_FIELDS = 'id,name,image[small]';
    const PIN_SCOPE = 'read_public, write_public';

// PDK.getSession();
// PDK.login({ scope :PIN_SCOPE }, PDK.getSession());
// PDK.init();










 /*
     *  Use the SDK to login to Pinterest
     *  @param {Function} callback - function fired on completion
     */
     function　login(callback) {
        PDK.login({ scope :PIN_SCOPE }, callback);
    }
    /*
     *  Use the SDK to logout of Pinterest
     */
     function　logout() {
        PDK.logout();
    }
    /*
     *  Use DK to determine auth state of user
     *  @returns {Boolean}
     */
     function　loggedIn() {
        return !!PDK.getSession();
    }
    /*
     *  Use SDK to create a new Pin
     *  @param {Object}   data     - {board, note, link, image_url}
     *  @param {Function} callback - function fired on completion
     */
     function　createPin(data, callback) {
        PDK.request('/pins/', 'POST', data, callback);
    }
    /*
     *  Use SDK to request current users boards
     *  @param {Function} callback - function fired on completion
     */
     function　myBoards(callback) {
        PDK.me('boards', { fields: PIN_FIELDS }, callback);
    }