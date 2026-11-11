const steps = document.getElementById('steps');
const add_button = document.getElementById('add_button');
const remove_button = document.getElementById('remove_button')
let step_number = 0;

add_button.addEventListener('click', () => {

    const new_step = document.createElement('div');
    new_step.classList.add('recipe_step');
    step_number++;

    new_step.innerHTML = `
        <label>Step ${step_number}</label>
        <input type="text" class="steps" name="steps[]" required>
    `;
    
    steps.appendChild(new_step);
    

})

remove_button.addEventListener('click', () => {

    
    if (steps.children.length > 0) {
           steps.removeChild(steps.lastChild);
           step_number--;
    }

    
 })