var editModuleButtons = document.getElementsByClassName('editModuleButton');
console.log(editModuleButtons);

for (let index = 0; index < editModuleButtons.length; index++) {
    const editModuleButton = editModuleButtons[index];
        editModuleButton.addEventListener('click',function(event){
        event.preventDefault();
        this.style.display="none";

        const formDurationBox = document.createElement('div');
        formDurationBox.id = 'formDurationBox';

        const message = document.createElement('p');
        message.textContent = 'Quelle sera la durée du module ?';
        formDurationBox.appendChild(message);

        const input = document.createElement('input');
        input.type = "number";
        input.setAttribute('min',1);
        formDurationBox.appendChild(input);


        const button = document.createElement('button');
        button.addEventListener('click',function () {
            window.location.href = editModuleButton.href.slice(0,-1)+input.value;
        });
        button.textContent = "Valider";
        formDurationBox.appendChild(button);

        const td = this.closest('td');
        td.appendChild(formDurationBox);

        console.log('coucou');
    })
    
}