
var options_input = {
    input: true,
    actions: {
        changeToInput(e, self) {
            if (!self.HTMLInputElement) return;
            if (self.selectedDates[0]) {
                self.HTMLInputElement.value = self.selectedDates[0];
                // if you want to hide the calendar after picking a date
                self.hide();
            } else {
                self.HTMLInputElement.value = '';
            }
        },
        initCalendar(self) {
            const btnEl = self.HTMLElement.querySelector("#btn-close");
            if (!btnEl) return;
            btnEl.addEventListener("click", self.hide);
        },
    },
    settings: {
        visibility: {
            theme: 'light',},
    }
};
document.addEventListener('DOMContentLoaded', () => {
    let datepicker_input = document.querySelectorAll('.datepicker-input');
    // datepicker_input.addEventListener('input')

    document.querySelectorAll('.datepicker-input')?.forEach(elem => {
        let calendar = new VanillaCalendar(elem, options_input);
        calendar.init();
    });
});

/*
* init calendar for task
*/
var task_option = {
    input: true,
    actions: {
        changeToInput(e, self) {
            if (!self.HTMLInputElement) return;
            if (self.selectedDates[0]) {
                self.HTMLInputElement.value = self.selectedDates[0];
                // if you want to hide the calendar after picking a date
                self.hide();
            } else {
                self.HTMLInputElement.value = '';
            }
        },
        // initCalendar(self) {
        //     const btnEl = self.HTMLElement.querySelector("#btn-close");
        //     if (!btnEl) return;
        //     btnEl.addEventListener("click", self.hide);
        // },
        clickDay(e, self) {
            let date = moment(self.selectedDates, "YYYY-MM-DD").format('DD MMM YYYY');
            let iso_date = moment(self.selectedDates, "YYYY-MM-DD").format(e.ISO_8601)

            self.HTMLInputElement.querySelector('.text-time').innerText = date;
            self.HTMLInputElement.querySelector('#task-date-input').value = iso_date;
        },
    },
    settings: {
        visibility: {
            theme: 'light',},
    }
};

(function(){
    let element = document.querySelector('.auto-resize');
    if(element){
        element.addEventListener('input', function(){
            autoResize.call(element)
        })
    }
    function autoResize() {
        this.style.height = 'auto'; // Reset the height
        this.style.height = `${this.scrollHeight}px`; // Set height to scrollHeight
    }
})()
