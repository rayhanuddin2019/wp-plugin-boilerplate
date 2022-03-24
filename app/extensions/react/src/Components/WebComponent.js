
class Mangocustomevent extends HTMLElement {

  constructor() {
    // Always call super first in constructor
    super();
    //this.attachShadow({mode: 'open'});
    // Element functionality written in here
    //this.shadowRoot.innerHTML = '<div> my component </div>';

    
  }

  updateStyle(elem) {
    const shadow = elem.shadowRoot;
    shadow.querySelector('style').textContent = `
    :host {
      --mangocube-heading-color: green;
    }
      div {
        width: ${elem.getAttribute('l')}px;
        height: ${elem.getAttribute('l')}px;
        background-color: ${elem.getAttribute('c')};
      }
      h2{
        color:var(--mangocube-heading-color);
      }
    `;
  }

  emitCustombuttonClick(data) {
    console.log('from inner' + data);
    const event = new CustomEvent('user_after_click_on_button', {
      detail: {
        message: 'Hello World',
      },
      bubbles: true,
      composed: true,
    });
    this.dispatchEvent(event);
  }

  connectedCallback() {
   
    const shadow = this.attachShadow({mode: 'open'});
   
    const div = document.createElement('div');
    const style = document.createElement('style');
    div.innerHTML = `<h2> Web component Heading </h2> <button> Click Me </button>`;
 
    shadow.appendChild(style);
    shadow.appendChild(div);
    this.updateStyle(this);
    // Select This component element only
    shadow.querySelector('button').addEventListener('click', (e) => { 
     
       this.emitCustombuttonClick(e.target.innerHTML);
    }); 

  }
}

customElements.define('e-custom-event', Mangocustomevent);

// Css modify Template Tag


var contgent_tpl = document.createElement('div')
var style = document.createElement('style');

style.textContent = `
:host {
  --mang-heading-color: green;
}
  
  h2{
    color:var(--mang-heading-color);
  }
`;
var h2_tag = document.createElement('h2');
h2_tag.innerText = 'Helo World';
contgent_tpl.appendChild(style);
contgent_tpl.appendChild(h2_tag);

class Mangocube_Mod_Style extends HTMLElement {

  constructor() {
    // Always call super first in constructor
    super();
    this.attachShadow({mode: 'open'});
    // Element functionality written in here
    this.shadowRoot.appendChild(contgent_tpl.cloneNode(true));
    //this.shadowRoot.innerHTML = '<div> my component </div>';

    
  }

}

customElements.define('e-global-css', Mangocube_Mod_Style);

// global css

class WhatsUp extends HTMLElement {
  
  connectedCallback() {
    this.innerHTML = `
      <style>
      button{
        color:#fff;
        background-color:#000;
        padding:10px;
        margin:10px;
        border-radius:50px;
      }
     </style> 
    <button>Sup?</button>
    `;
    const button = this.querySelector("button");
    button.addEventListener("click", this.handleClick);
  }
  
  handleClick(e) {
    alert("Sup?");
  }
  
}

window.customElements.define('whats-up', WhatsUp);

// put css in customizer->additional css / Style file

// whats-up button {
//   border-radius: 20px;
//   color: white;
//   padding: 1rem 2rem;
//   border: 0;
//   font-size: 1.9rem;
// }

