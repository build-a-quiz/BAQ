async function addFreeText() {

    const {value: question} = await Swal.fire({
        title: 'Bitte Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const {value: solution} = await Swal.fire({
        title: 'Bitte Antwort eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    })

    // write question to temp array and print on preview
    if(question && solution && points) {
        allQ.push({"id":1,"type":"freetext","question":question,"solution":solution,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
                <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
                <div class='col-xs-3'>\
                    <input class='form-control' id='x3' type='text' placeholder='Bitte Antwort hier eingeben...'>\
                </div>"
    }
}


async function addDropDown(){
    const {value: question} = await Swal.fire({
        title: 'Bitte DropDown-Frage eingeben:',
        icon: 'question',
        input: 'text',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });

    const { value: answers } = await Swal.fire({
        title: 'Antwortmöglichkeiten definieren',
        html:
            '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">'+
            '<input id="swal-input3" class="swal2-input">'+
            '<input id="swal-input4" class="swal2-input">',
            focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value
            ]
        }
    })

    let {value: solution} = await Swal.fire({
        title: answers,
        icon: 'question',
        input: 'text',
        inputLabel : 'Bitte richtige Antwort angeben:',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                return 'Schreiben oder Abbrechen!'
            }
        }
    });
    solution = answers.indexOf(solution);

    const {value: points} = await Swal.fire({
        title: 'Wie viel Punkte gibt es auf die Frage?',
        icon: 'question',
        input: 'range',
        inputAttributes: {
            min: 1,
            max: 10,
            step: 1
        },
        inputValue: 1
    })

    // write question to temp array and print on preview
    if(question && answers && solution && points) {

        allQ.push({"id":1,"type":"dropdown","question":question,"answers":answers,"solution":solution,"points":points})
        console.log(allQ);

        // update preview div
        let preview = document.getElementById('preview').innerHTML;
        document.getElementById('preview').innerHTML=preview +"<br><br><hr><br>\
            <h4 class='display-8'>"+question+" ("+points+" Punkte)</h4>\
            <div class='col-xs-3'>\
            <select class='form-select' id='x3' aria-label='Bitte Antwort auswählen'>\
               <option>Bitte Antwort auswählen...</option>\
        </select>\
        </div>"
    }


}