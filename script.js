var lang = {};

function loadLanguage(language) {
    fetch(language + '.json')
        .then(response => response.json())
        .then(data => {
            lang[language] = data;
            if (language === 'fr') {
                changeLanguage(language); // Set default language to French
            }
        });
}

function changeLanguage(language) {
    var langKeys = Object.keys(lang[language]);
    for (var i = 0; i < langKeys.length; i++) {
        var element = document.getElementById(langKeys[i]);
        if (element) {
            element.textContent = lang[language][langKeys[i]].replace(/\\n/g, '<br>');
        }
    }
}

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Load languages and set default language to French
loadLanguage('fr');
loadLanguage('en');