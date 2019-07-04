(function () {
    if (!localStorage.getItem('cookieconsent')) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(request.responseText);
                var country_code2 = ['AL', 'AD', 'AM', 'AT', 'BY', 'BE', 'BA', 'BG', 'CH', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FO', 'FI', 'FR', 'GB', 'GE', 'GI', 'GR', 'HU', 'HR', 'IE', 'IS', 'IT', 'LT', 'LU', 'LV', 'MC', 'MK', 'MT', 'NO', 'NL', 'PO', 'PT', 'RO', 'RU', 'SE', 'SI', 'SK', 'SM', 'TR', 'UA', 'VA'];
                if (country_code2.indexOf(data.countryCode2) != -1) {
                    document.body.innerHTML += '\
					<div class="cookieconsent" style="position:fixed;padding:20px;left:0;bottom:0;background-color:#000;color:#FFF;text-align:center;width:100%;z-index:99999;">\
                    Ce site utilise des cookies. En poursuivant votre navigation sur ce site, vous acceptez leur utilisation. \
						<a href="#" style="color:#CCCCCC;">Je comprends</a>\
					</div>\
					';
                    document.querySelector('.cookieconsent a').onclick = function (e) {
                        e.preventDefault();
                        document.querySelector('.cookieconsent').style.display = 'none';
                        localStorage.setItem('cookieconsent', true);
                    };
                }
            }
        };
        request.open('GET', 'https://api.ipgeolocation.io/ipgeo?apiKey=b208ef369c1a4773bcd49740f4f7ea6a', true);
        request.send();
    }
})();