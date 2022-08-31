function onClickBtnLike(event) {

   const notyf = new Notyf({
  duration: 2500,
  position: {
    x: 'center',
    y: 'top',
  }
});

// Display an error notification
    event.preventDefault();
    const url = this.href;
    const icone = this.querySelector('i');
    // console.log(icone.classList.value);

    axios.get(url).then(function (response) {
        if (icone.classList.value=="icon-heart icons") {
            icone.classList.value = "fa fa-heart";
            notyf.success('Ajouter dans vos fovoris');
        }
        else {
           icone.classList.value = "icon-heart icons";
           notyf.error('Supprimer de vos fovoris');
        }
        console.log(icone.classList.value)
    }).catch(function (error) {
        if (error.response.status === 403) {
            // window.alert('Vous n\'êtes pas connecté');
            notyf.error('Veillez vous connecter');
            //event.stopPropagation();
        }
        else notyf.error('Une erreur s\'est produite');
    });

}

document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
})