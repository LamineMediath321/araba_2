
    const prevBtns = document.querySelectorAll('.btn-prev')
    const nextBtns = document.querySelectorAll('.btn-next')
    const progress = document.getElementById('progress')
    const formSteps = document.querySelectorAll('.step-forms')
    const progressSteps = document.querySelectorAll('.progress-step')
    
    let formStepsNum = 0
    
    nextBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const salle = document.getElementById('form_nomSalle'); 
        const file = document.getElementById('form_imageFile'); 
        

        let p = document.getElementById('errorSalle')
        let pFile = document.getElementById('errorFile')

        if (salle.value == '' || file.value=='') {    //Check if a file was selected 
           if(salle.value == ''){
             p.innerHTML="Veillez saisir le nom de votre Boutique";
             p.classList = "alert alert-danger"
           }
           if(file.value == ''){
             pFile.innerHTML="Veillez inserer une image";
             pFile.classList = "alert alert-danger"
           }
        }
        else{
          formStepsNum++
          updateFormSteps()
          updateProgressbar()
          p.innerHTML="";
          p.classList = ""
          pFile.innerHTML="";
          pFile.classList = ""
        }
      })
    })
    
    prevBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        formStepsNum--
        updateFormSteps()
        updateProgressbar()
      })
    })
    
    function updateFormSteps() {
      formSteps.forEach((formStep) => {
        formStep.classList.contains('step-forms-active') && formStep.classList.remove('step-forms-active')
      })
    
      formSteps[formStepsNum].classList.add('step-forms-active')
    }
    
    function updateProgressbar() {
      progressSteps.forEach((progressStep, idx) => {
        if (idx < formStepsNum + 1) {
          progressStep.classList.add('progress-step-active')
        } else {
          progressStep.classList.remove('progress-step-active')
        }
      })
    
      progressSteps.forEach((progressStep, idx) => {
        
        if (idx < formStepsNum) {
          progressStep.classList.add('progress-step-check')
        } else {
          progressStep.classList.remove('progress-step-check')
        }
      })
    
      const progressActive = document.querySelectorAll('.progress-step-active')
    
      progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + '%'
    }
    
    document.getElementById('submit-form').addEventListener('click', function () {
      // progressSteps.forEach((progressStep, idx) => {
        

      //   if (idx <= formStepsNum) {
      //       progressStep.classList.add('progress-step-check')
      //   } else {
      //     progressStep.classList.remove('progress-step-check')
      //   }
      // })
      
        let pPays = document.getElementById('errorPays')
            let pVille = document.getElementById('errorVille')
            const pays = document.getElementById('form_pays'); 
            const ville = document.getElementById('form_ville'); 
            if (pays.value == '' || ville.value=='') {    //Check if a file was selected 
                if(pays.value == ''){
                    pPays.innerHTML="Veillez saisir Pays";
                    pPays.classList = "alert alert-danger"
                }
                if(ville.value == ''){
                    pVille.innerHTML="Veillez saisir la ville";
                    pVille.classList = "alert alert-danger"
                }
            }
            else{
                var forms = document.getElementById('forms')
                // var div = document.getElementById('inner')
                // // forms.classList.remove('form')
                // div.innerHTML = 
                //     '<div class="welcome col-6 mx-auto"><div class="content"><svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg><h2 class="text-center">Merci pour votre inscription !</h2><span> <p class="mt-2"><a class="btn btn-danger">Continuez</a></p> </span><div></div>'
                forms.submit();
            }
      
    })
  
