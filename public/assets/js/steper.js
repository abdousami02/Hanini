
const DEFAULT_OPTIONS = {
    linear: true,
    // animation: false,
    selectors: {
        steps: '.step',
        currentStep: 1,
        trigger: '.step-trigger',
        btnNext: '#next',
        btnPrev: '#previous',
        btnSubmit: '#submit',
    },
    changeStep: function(step, output){}
}

class Stepper {

    constructor(element, options){

        this._option = {
            ...DEFAULT_OPTIONS,
            ...options
        }


        if(element instanceof HTMLElement){
            this._element = element;

        }else {
            this._element = document.querySelector(element);
        }

        if(!this._element){
            console.warn('element is not HTML Element in Stepper Class')
            return false;
        }

        this.currentStep = this._option.selectors.currentStep;
        this._stepsContents = [];

        this.previousButton = this._element.querySelector(this._option.selectors.btnPrev);
        this.nextButton = this._element.querySelector(this._option.selectors.btnNext);
        this.submitButton = this._element.querySelector('validate');

        // const form = document.getElementById('stepByStepForm')
        // this.all_steps = this._element.querySelectorAll(this._option.steps)
        this.all_steps = [].slice.call(this._element.querySelectorAll(this._option.selectors.steps))

    
        const _stepsContents = this._element.querySelectorAll('.stepper-content .stepper-pan');
        // const all_steps = this._element.querySelectorAll('.steper-progress-bar .step');
    
        // let currentStep = 2;
        this.numberOfSteps = this.all_steps.length

        this._setLinkListeners();



        // console.log(this.all_steps);
        this.all_steps.filter(step => step.hasAttribute('data-target')).forEach(step => {
            let element = this._element.querySelector(step.getAttribute('data-target'))
            if(element){
                this._stepsContents.push(element)
            }
        })

        // console.log(previousButton);
        this.previousButton.onclick = ()=>{this.goPrevious}
        this.nextButton.onclick = ()=>{this.goNext(this)};

        this.init();

    }

    _setLinkListeners () {
        if(this._option.linear){
            return false;
        }
        this.all_steps.forEach((step, index) => {
            const trigger = step.querySelector(this._option.selectors.trigger)
            if(trigger){
                trigger.addEventListener('click', ()=>{
                    this.goToStep(index+1);
                })
            }

        //   if (this.options.linear) {
        //     this._clickStepLinearListener = buildClickStepLinearListener(this.options)
        //     trigger.addEventListener('click', this._clickStepLinearListener)
        //   } else {
        //     this._clickStepNonLinearListener = buildClickStepNonLinearListener(this.options)
        //     trigger.addEventListener('click', this._clickStepNonLinearListener)
        //   }

        })
    }

    init() {
        this.currentStep = this._option.selectors.currentStep
        this.goToStep(this.currentStep, true)
    }

    goNext(self) {
        console.log(self)
        // console.log(e);
        // e.preventDefault()
        self.goToStep(this.currentStep+1)
    }

    goPrevious(self) {
        // e.preventDefault()
        self.goToStep(this.currentStep-1)
    }

    goToStep(stepNumber, isFirst=false){ 
        // if(this.oldStep  this.currentStep)
        // this.oldStep = this.currentStep; 
        // this.currentStep = stepNumber;
        // newStep = 

        if((stepNumber > this.numberOfSteps) || (stepNumber < 1)) {
            return false;
        }

        // let current_step  = document.querySelector('.steper-progress-bar .step.active');

        this._stepsContents.forEach((elem, index) => {
            elem.classList.remove('show')
            // console.log(elem, index)
        });

        this.all_steps.forEach((elem, index) => {
            if((index + 1) == stepNumber){
                elem.classList.add('active');
                let content = document.querySelector(elem.dataset.target)
                if(content){
                    content.classList.add('show')
                }

                this.enable_btn(elem)
                if(!isFirst){
                    this._option.changeStep(index+1, content);
                }

            }else{
                elem.classList.remove('active');

            }

            if(stepNumber < index+1 && stepNumber >= this.currentStep){
                this.disable_btn(elem)
            }
        });

        //if we reached final step
        // console.log(this.currentStep)
        if(stepNumber === this.numberOfSteps){
            this.enable_btn(this.previousButton)
            this.disable_btn(this.nextButton)
            // show(submitButton)

        } else if(stepNumber === 1){ //else if first step
            this.disable_btn(this.previousButton)
            this.enable_btn(this.nextButton)
            // hide(submitButton)

        }else {
            this.enable_btn(this.previousButton)
            this.enable_btn(this.nextButton)
            // hide(submitButton)
        }

    }


    enable_btn(elem) {
        // console.log(elem)
        elem.classList.remove("disabled");
        elem.disabled = false;
    }

    disable_btn(elem) {
        elem.classList.add("disabled");
        elem.disabled = true;
    }

    // function show(elem){
    // //    elem.classList.remove('hidden')
    //     elem.classList.add('show')
    // }

    // function hide(elem){
    // //    elem.classList.add('hidden')
    //     elem.classList.remove('show')
    // }

}

