var addModuleButtons = document.getElementsByClassName('addModuleButton');
console.log(addModuleButtons);

for (let index = 0; index < addModuleButtons.length; index++) {
    const addModuleButton = addModuleButtons[index];
        addModuleButton.addEventListener('click',function(event){
        event.preventDefault();
        this.style.display="none";

        const formDurationBox = document.createElement('div');
        formDurationBox.id = 'formDurationBox';

        const message = document.createElement('p');
        message.textContent = 'Quelle sera la durée du module ?';
        formDurationBox.appendChild(message);

        const input = document.createElement('input');
        input.type = "number";
        input.min="0";
        formDurationBox.appendChild(input);


        const button = document.createElement('button');
        button.addEventListener('click',function () {
            window.location.href = addModuleButton.href.slice(0,-1)+input.value;
        });
        button.textContent = "Valider";
        formDurationBox.appendChild(button);

        const td = this.closest('td');
        td.appendChild(formDurationBox);

        console.log('coucou');
    })
    
}