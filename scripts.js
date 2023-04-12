
    function toggleLanguage() {
      var elements = document.querySelectorAll("[id$='-en'], [id$='-fa']");
      for (var i = 0; i < elements.length; i++) {
        if (elements[i].style.display === "none") {
          elements[i].style.display = "block";
        } else {
          elements[i].style.display = "none";
        }
      }
    }
  
