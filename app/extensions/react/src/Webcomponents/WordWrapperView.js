import Wordwrapper from '../Components/Wordwrapper';

const { render } = wp.element;

class MangoCube_Text_Wrapper extends HTMLElement {
  connectedCallback() {

      this.innerHTML = `     
    <span></span>
    `;
    const mountPoint = this.querySelector("span");
    
    // this.attachShadow({ mode: 'open' }).appendChild(mountPoint);

     render(<Wordwrapper />, mountPoint);

  }
}

customElements.define('mangocube-text-wrapper', MangoCube_Text_Wrapper);
