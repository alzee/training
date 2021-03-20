let input = document.querySelector('input#customFile');
if(input){
    input.addEventListener('change', function(){
        let fileName = input.files[0].name;
        input.nextElementSibling.innerText = fileName;
    }
    );
}
