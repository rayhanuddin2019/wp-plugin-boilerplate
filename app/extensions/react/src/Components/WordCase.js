
import './css/wordcase.scss';
const { Component } = wp.element;

export default class WordCase extends Component{

	constructor(props){

		super(props);

		this.state = {

			count: 0,
		    ouput: '',
            input: '',
            lower_case: false,
            upper_case: false,
            toggle_case: false,
            sentence_case: false,
            alternet_case: false,
            capitalize_case: false,
            strikethrough : false,
            swapcase : false,
            active : false

            
		};
	}

    swapcase(str) {
        return str.replace(/([a-z]+)|([A-Z]+)/g, function(match, chr) {
            return chr ? match.toUpperCase() : match.toLowerCase();
        });
    }

    toggle_case(input) {
        var stringArray = input.split(''); // Turn string into array

        stringArray = stringArray.map(function(current, index, stringArray) {
            if (current.toLowerCase() === current) {
                return current.toUpperCase(); // If a character is lowercase, switch to uppercase
            } else {
                return current.toLowerCase(); // Else, switch to lowercase
            }
        });
        return stringArray.join(''); // Join array into string again
    }

    strikeThrough(text) {
        return text
          .split('')
          .map(char => char + '\u0336')
          .join('')
    }

    titleCase(str) {
        return str.toLowerCase().split(' ').map(function(word) {
          return (word.charAt(0).toUpperCase() + word.slice(1));
        }).join(' ');
    }

     sentencecase(a) {
        a = a.toLowerCase();
        var b = true;
        var c = "";
        for (var d = 0; d < a.length; d++) {
            var e = a.charAt(d);
            if (/\.|\!|\?|\n|\r/.test(e)) {
                b = true;
            } else if (e.trim() != "" && b == true) {
                e = e.toUpperCase();
                b = false;
            }
            c += e;
        }
        return c;
    }

    alternatingcase(a) {
        a = a.toLowerCase();
        var b = "";
        for (var c = 0; c < a.length; c++) {
            var d = a.charAt(c);
            if (c % 2) {
                b += d.toUpperCase();
            } else {
                b += d;
            }
        }
        return b;
    }

    handle_Option_Change(option,event){
        event.preventDefault();
        this.setState({[option]: !this.state[option]});
        var input = this.state.input;
        if(option == 'lower_case'){
  
            this.setState({input: input.toLowerCase()});
            this.setState({output: input.toLowerCase()});
        }

        if(option == 'upper_case'){
                
            //this.setState({input: input.toUpperCase()});
            this.setState({output: input.toUpperCase()});
        }

        if(option == 'strikethrough'){
                
            //this.setState({input: this.strikeThrough(input)});
            this.setState({output: this.strikeThrough(input)});
        }

        if(option == 'toggle_case'){
  
           // this.setState({input: this.toggle_case(input)});
            this.setState({output: this.toggle_case(input)});
        } 


          if(option == 'capitalize_case'){
  
            //this.setState({input: this.titleCase(input)});
            this.setState({output: this.titleCase(input)});
        } 
        
        if(option == 'swapcase'){
  
            //this.setState({input: this.swapcase(input)});
            this.setState({output: this.swapcase(input)});
        }
        
        if(option == 'sentence_case'){
  
            //this.setState({input: this.sentencecase(input)});
            this.setState({output: this.sentencecase(input)});
        }

        if(option == 'alternet_case'){
  
            //this.setState({input: this.alternatingcase(input)});
            this.setState({output: this.alternatingcase(input)});
        }



        this.setState({count: input.length});
      
    }

    hanlde_text_input(event){
   
        this.setState({input: event.target.value});
       // this.setState({output: event.target.value});
        
   
    }
  
    handle_content_copy(event){
      
       navigator.clipboard.writeText(this.state.output);
       event.target.innerHTML = 'Copied'; 
       setTimeout(() => {
        event.target.innerHTML = 'Copy All'; 
       },2000);
	}
    
    handle_content_download(event){

        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(this.state.output));
        element.setAttribute('download', 'case-content.txt');
    
        element.style.display = 'none';
        document.body.appendChild(element);
    
        element.click();
    
        document.body.removeChild(element);
	}

   
    
	
	render() {
		
		return (
			<div>
                <div className="container mangocube-text-case">
                    
                    <div class="row align-items-center">
                       
                        <div class="col-md-12 justify-content-end">
                           <div class="d-flex flex-wrap mangocube-case-control-wrapper">

                                <button onClick={this.handle_Option_Change.bind( this , 'toggle_case')} class="btn btn-primary"> Toggle Case </button>
                                {/* <button onClick={this.handle_Option_Change.bind( this , 'swapcase')} class="btn btn-primary"> SwapCase </button> */}
                                <button onClick={this.handle_Option_Change.bind( this , 'sentence_case')} class="btn btn-primary"> Sentance Case </button>
                                <button onClick={this.handle_Option_Change.bind( this , 'upper_case')} class="btn btn-secondary">  Upper Case </button>
                                <button onClick={this.handle_Option_Change.bind( this , 'lower_case')} class="btn btn-primary"> Lower Case </button>
                                <button onClick={this.handle_Option_Change.bind( this , 'capitalize_case')} class="btn btn-secondary"> Title Case </button>
                                <button onClick={this.handle_Option_Change.bind( this , 'alternet_case')} class="btn btn-primary"> Alternate Case </button>
                                <button onClick={this.handle_Option_Change.bind( this , 'strikethrough')} class="btn btn-primary"> StrikeThrough </button>

                           </div>
                        </div>
                        <div class="col-md-12">

                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h4 class="mangocube-case-input-heading"> Enter Input </h4> 
                                </div>
                                <div class="col-md-8">
                                    <div class="mangocube-result-grab justify-content-end d-flex">
                                        <button onClick={this.handle_content_copy.bind( this )} type="button" class="btn btn-primary mangocube-content-copy">Copy All</button>
                                        <button onClick={this.handle_content_download.bind( this )} type="button" class="btn btn-secondary mangocube-download-txt-down">Download</button>
                                        {this.state.count > 0 &&
                                        <div class="mangocube-total-keywords"> Total length {this.state.count} </div>
                                        }
                                        
                                    </div>
                                </div>      
                            </div> 
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                                <textarea onInput={this.hanlde_text_input.bind(this)} rows="15" class="form-control" aria-label="With textarea"></textarea>
                            </div> 
                        </div>

                        <div class="col-sm-6">
                          <div class="input-group">
                                <textarea value={this.state.output} rows="15" class="form-control" aria-label="With textarea"></textarea>
                            </div> 
                        </div>
   
                    </div>
                </div> 
				
			</div>
		);
	}
}


