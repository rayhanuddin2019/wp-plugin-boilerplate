
import './css/wordwrapper.scss';
const { Component } = wp.element;

export default class Wordwrapper extends Component{

	constructor(props){

		super(props);

        this.broad_match_ref = React.createRef();
        this.phrase_match_ref = React.createRef();
        this.exact_match_ref = React.createRef();

		this.state = {
			count: 0,
			text: "Click",
            keyword_ouput: [],
            keywords_input: [],
            broad_match: true,
            all_match: true,
        
            phrase_match: false,
            exact_match: false,
            lowercase: false,
            remove_duplicate: false,
            remove_symbol: false,
            remove_space: true

            
		};
	}

    manipulate_keywords_text(){
   
      
        setTimeout(() => {

            var manipulate__final_keywords = this.state.keywords_input;
   
            // remove symbol

            if(this.state.remove_symbol){
               
                manipulate__final_keywords = manipulate__final_keywords.map(function(item){
                    return item.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/g, '');
                });
                
            }
           
            if(this.state.remove_space){

                manipulate__final_keywords = manipulate__final_keywords.map(function(item){
                    return item.replace(/\s+/g, " ").trim();
                });
                
            }
            

            //toLowerCase

            if(this.state.lowercase){
                manipulate__final_keywords = manipulate__final_keywords.map(function(item){
                    return item.toLowerCase();
                });
            }

            // remove duplicate
            if(this.state.remove_duplicate){
                manipulate__final_keywords = manipulate__final_keywords.reduce(function(a,b){
                    if (a.indexOf(b) < 0 ) a.push(b);
                    return a;
                  },[]);
            }

            var store_final_keywords = [];

            
            manipulate__final_keywords.forEach(function(line) {

                if(line.length > 0){ 
  
                    if( this.state.broad_match ){

                        store_final_keywords.push(line);

                    }

                    if( this.state.exact_match ){
                    
                        store_final_keywords.push('[' + line + ']');

                    }

                    if( this.state.phrase_match ){

                        store_final_keywords.push('"' + line + '"');

                    }

                   
                } // end line length
               

            }.bind(this));
         

            this.setState({keyword_ouput: store_final_keywords.join('\n')});

        }, 500);
    }
    
    handle_manipulate_final_result(item, index, arr) {
        arr[index] = item * 10;
    }
	
	handle_Text_Input(event){

		this.setState({
            count: event.target.value.split('\n').length,
            keywords_input: event.target.value.split('\n')
        });
        
        // manipulate all logic here
        this.manipulate_keywords_text();
       
	}

    handle_Option_Change(option,event){
      
       if(event.target.checked)
        {
        	this.setState({[option]: true});
            
        }else{
            this.setState({[option]: false});
        }

        this.manipulate_keywords_text();
	}

    handle_all_match_Change(event){
        
        this.broad_match_ref.current.Checked = true;
        this.phrase_match_ref.current.Checked = true;
        this.exact_match_ref.current.Checked = true;
        if(event.target.checked)
        {
            this.setState({all_match: true});
            this.setState({broad_match: true});
            this.setState({exact_match: true});
            this.setState({phrase_match: true});
        }else{
            this.setState({all_match: false});
            this.setState({broad_match: false});
            this.setState({exact_match: false});
            this.setState({phrase_match: false});
        }
        
        this.manipulate_keywords_text();
    
    }

    handle_content_copy(event){
      
       navigator.clipboard.writeText(this.state.keyword_ouput);
       event.target.innerHTML = 'Copied'; 
       setTimeout(() => {
        event.target.innerHTML = 'Copy All'; 
       },2000);
	}
    
    handle_content_download(event){
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(this.state.keyword_ouput));
        element.setAttribute('download', 'keywords.txt');
    
        element.style.display = 'none';
        document.body.appendChild(element);
    
        element.click();
    
        document.body.removeChild(element);
	}

   
    
	
	render() {
		
		return (
			<div>
                <div className="container">
                    <div className="row mb-3 align-items-end">
                        <div className="col-md-6">
                            <div className="mangocube-wordwrap-customizer"> 
                                <div class="mangocube-tools-wr-h"> Match Types </div> 
                                <hr/>

                                <div class="form-check form-switch">
                                    <input onChange={this.handle_all_match_Change.bind( this )} class="form-check-input" type="checkbox" id="mangocube-all-match" />
                                    <label class="form-check-label" for="mangocube-all-match">All Match* </label>
                                </div>

                                <div class="form-check form-switch">
                                    <input ref={this.broad_match_ref} checked={this.state.broad_match} onChange={this.handle_Option_Change.bind( this , 'broad_match')} class="form-check-input m-broad" type="checkbox" id="mangocube-broad-match" />
                                    <label class="form-check-label" for="mangocube-broad-match">Broad Match </label>
                                </div>
                                
                                <div class="form-check form-switch">
                                    <input ref={this.phrase_match_ref} checked={this.state.phrase_match} onChange={this.handle_Option_Change.bind( this , 'phrase_match')} class="form-check-input m-broad" type="checkbox" id="mangocube-phrase-match" />
                                    <label class="form-check-label" for="mangocube-phrase-match">"Phrase Match"</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input ref={this.exact_match_ref} checked={this.state.exact_match} onChange={this.handle_Option_Change.bind( this , 'exact_match')} class="form-check-input m-broad" type="checkbox" id="mangocube-exact-match" />
                                    <label class="form-check-label" for="mangocube-exact-match">[Exact  Match]</label>
                                </div>

                                <div class="mangocube-tools-wr-h mt-3"> Advanced Settings </div> 
                                <hr/>
                                <div class="form-check form-switch">
                                    <input onChange={this.handle_Option_Change.bind( this , 'lowercase')} class="form-check-input" type="checkbox" id="mangocube-lower-case" />
                                    <label class="form-check-label" for="mangocube-lower-case">Transform To Lowercase</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input defaultChecked={this.state.remove_duplicate} onChange={this.handle_Option_Change.bind( this , 'remove_duplicate')} class="form-check-input" type="checkbox" id="mangocube-remove-duplicate" />
                                    <label class="form-check-label" for="mangocube-remove-duplicate">Remove Duplicate</label>
                                </div> 
                                <div class="form-check form-switch">
                                    <input onChange={this.handle_Option_Change.bind( this , 'remove_symbol')} class="form-check-input" type="checkbox" id="mangocube-remove-symbol" />
                                    <label class="form-check-label" for="mangocube-remove-symbol">Remove Symbol</label>
                                </div> 
                                <div class="form-check form-switch">
                                    <input defaultChecked={this.state.remove_space} onChange={this.handle_Option_Change.bind( this , 'remove_space')} class="form-check-input" type="checkbox" id="mangocube-remove-space" />
                                    <label class="form-check-label" for="mangocube-remove-space">Remove Space</label>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="mangocube-result-grab d-flex">
                                <button onClick={this.handle_content_copy.bind( this )} type="button" class="btn btn-primary mangocube-content-copy">Copy All</button>
                                <button onClick={this.handle_content_download.bind( this )} type="button" class="btn btn-secondary mangocube-download-txt-down">Download</button>
                                {this.state.count > 0 &&
                                   <div class="mangocube-total-keywords"> Total Keywords {this.state.count} </div>
                                }
                                
                            </div>
                         </div>       
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="card mangocube-wordwrap-heading wr-input-heading">
                                <div class="card-body">
                                  <h4> Enter Keywords </h4> 
                                </div>
                            </div>
                            <div class="input-group">
                              
                                <textarea onInput={this.handle_Text_Input.bind(this)} rows="20" class="form-control" aria-label="With textarea"></textarea>
                            </div> 
                        </div>
                        <div class="col-md-6 col-sm-12">
                          
                            <div class="card mangocube-wordwrap-heading wr-result-heading">
                                <div class="card-body">
                                  <h4> Results </h4>
                                </div>
                            </div>
                            
                            <div class="input-group">
                            
                                <textarea rows="20" class="form-control" aria-label="With textarea" value={this.state.keyword_ouput}></textarea>
                            </div>
                        </div>
                    </div>
                </div> 
				
			</div>
		);
	}
}


