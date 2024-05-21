(()=>{"use strict";var e={5773:(e,t,n)=>{n.d(t,{Z:()=>i});var r=n(1519),a=n.n(r)()((function(e){return e[1]}));a.push([e.id,'.half-circle-spinner,.half-circle-spinner *{box-sizing:border-box}.half-circle-spinner{border-radius:100%;height:60px;position:relative;width:60px}.half-circle-spinner .circle{border:6px solid transparent;border-radius:100%;content:"";height:100%;position:absolute;width:100%}.half-circle-spinner .circle.circle-1{animation:half-circle-spinner-animation 1s infinite;border-top-color:#ff1d5e}.half-circle-spinner .circle.circle-2{animation:half-circle-spinner-animation 1s infinite alternate;border-bottom-color:#ff1d5e}@keyframes half-circle-spinner-animation{0%{transform:rotate(0)}to{transform:rotate(1turn)}}',""]);const i=a},1519:e=>{e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,r){"string"==typeof e&&(e=[[null,e,""]]);var a={};if(r)for(var i=0;i<this.length;i++){var o=this[i][0];null!=o&&(a[o]=!0)}for(var c=0;c<e.length;c++){var l=[].concat(e[c]);r&&a[l[0]]||(n&&(l[2]?l[2]="".concat(n," and ").concat(l[2]):l[2]=n),t.push(l))}},t}},3379:(e,t,n)=>{var r,a=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},i=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),o=[];function c(e){for(var t=-1,n=0;n<o.length;n++)if(o[n].identifier===e){t=n;break}return t}function l(e,t){for(var n={},r=[],a=0;a<e.length;a++){var i=e[a],l=t.base?i[0]+t.base:i[0],s=n[l]||0,d="".concat(l," ").concat(s);n[l]=s+1;var u=c(d),f={css:i[1],media:i[2],sourceMap:i[3]};-1!==u?(o[u].references++,o[u].updater(f)):o.push({identifier:d,updater:v(f,t),references:1}),r.push(d)}return r}function s(e){var t=document.createElement("style"),r=e.attributes||{};if(void 0===r.nonce){var a=n.nc;a&&(r.nonce=a)}if(Object.keys(r).forEach((function(e){t.setAttribute(e,r[e])})),"function"==typeof e.insert)e.insert(t);else{var o=i(e.insert||"head");if(!o)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");o.appendChild(t)}return t}var d,u=(d=[],function(e,t){return d[e]=t,d.filter(Boolean).join("\n")});function f(e,t,n,r){var a=n?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(e.styleSheet)e.styleSheet.cssText=u(t,a);else{var i=document.createTextNode(a),o=e.childNodes;o[t]&&e.removeChild(o[t]),o.length?e.insertBefore(i,o[t]):e.appendChild(i)}}function m(e,t,n){var r=n.css,a=n.media,i=n.sourceMap;if(a?e.setAttribute("media",a):e.removeAttribute("media"),i&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(i))))," */")),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}var p=null,h=0;function v(e,t){var n,r,a;if(t.singleton){var i=h++;n=p||(p=s(t)),r=f.bind(null,n,i,!1),a=f.bind(null,n,i,!0)}else n=s(t),r=m.bind(null,n,t),a=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return r(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;r(e=t)}else a()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=a());var n=l(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var r=0;r<n.length;r++){var a=c(n[r]);o[a].references--}for(var i=l(e,t),s=0;s<n.length;s++){var d=c(n[s]);0===o[d].references&&(o[d].updater(),o.splice(d,1))}n=i}}}},3744:(e,t)=>{t.Z=(e,t)=>{const n=e.__vccOpts||e;for(const[e,r]of t)n[e]=r;return n}}},t={};function n(r){var a=t[r];if(void 0!==a)return a.exports;var i=t[r]={id:r,exports:{}};return e[r](i,i.exports,n),i.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),n.nc=void 0,(()=>{const e=Vue;var t={class:"max-width-1200"},r={class:"flexbox-annotated-section"},a=(0,e.createElementVNode)("div",{class:"flexbox-annotated-section-annotation"},[(0,e.createElementVNode)("div",{class:"annotated-section-title pd-all-20"},[(0,e.createElementVNode)("h2",null,"License")]),(0,e.createElementVNode)("div",{class:"annotated-section-description pd-all-20 p-none-t"},[(0,e.createElementVNode)("p",{class:"color-note"},"Setup license code")])],-1),i={class:"flexbox-annotated-section-content"},o={class:"wrapper-content pd-all-20"},c={key:0,style:{margin:"auto",width:"30px"}},l={key:1},s={class:"note note-warning"},d={key:0},u={key:1},f={class:"form-group mb-3"},m=(0,e.createElementVNode)("label",{class:"text-title-field",for:"buyer"},"Your username on Envato",-1),p=["disabled","readonly"],h=(0,e.createElementVNode)("div",null,[(0,e.createElementVNode)("small",null,[(0,e.createTextVNode)("If your profile page is "),(0,e.createElementVNode)("a",{href:"https://codecanyon.net/user/john-smith",rel:"nofollow"},"https://codecanyon.net/user/john-smith"),(0,e.createTextVNode)(", then your username on Envato is "),(0,e.createElementVNode)("strong",null,"john-smith"),(0,e.createTextVNode)(".")])],-1),v={class:"form-group mb-3"},b=(0,e.createStaticVNode)('<div><div class="float-start"><label class="text-title-field" for="purchase_code">Purchase code</label></div><div class="float-end text-end"><small><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank">What&#39;s this?</a></small></div><div class="clearfix"></div></div>',1),g=["disabled","readonly"],y={class:"form-group mb-3"},E=["disabled","readonly"],N=(0,e.createElementVNode)("a",{href:"https://codecanyon.net/licenses/standard",target:"_blank",rel:"nofollow"},"More info",-1),V={class:"form-group mb-3"},x=["disabled"],L=["disabled"],w=(0,e.createElementVNode)("hr",null,null,-1),C=(0,e.createElementVNode)("div",{class:"form-group mb-3"},[(0,e.createElementVNode)("p",null,[(0,e.createElementVNode)("small",{class:"text-danger"},"Note: Your site IP will be added to blacklist after 5 failed attempts.")]),(0,e.createElementVNode)("p",null,[(0,e.createElementVNode)("small",null,[(0,e.createTextVNode)("A purchase code (license) is only valid for One Domain. Are you using this theme on a new domain? Purchase a "),(0,e.createElementVNode)("a",{href:"https://codecanyon.net/user/botble/portfolio",target:"_blank",rel:"nofollow"},"new license here"),(0,e.createTextVNode)(" to get a new purchase code.")])])],-1),S={key:2},k={class:"text-info"},B={class:"form-group mb-3"},_=["disabled"];var T=n(3379),A=n.n(T),j=n(5773),M={insert:"head",singleton:!1};A()(j.Z,M);j.Z.locals;const U={components:{HalfCircleSpinner:((e,t)=>{const n=e.__vccOpts||e;for(const[e,r]of t)n[e]=r;return n})({name:"HalfCircleSpinner",props:{animationDuration:{type:Number,default:1e3},size:{type:Number,default:60},color:{type:String,default:"#fff"}},computed:{spinnerStyle(){return{height:`${this.size}px`,width:`${this.size}px`}},circleStyle(){return{borderWidth:this.size/10+"px",animationDuration:`${this.animationDuration}ms`}},circle1Style(){return Object.assign({borderTopColor:this.color},this.circleStyle)},circle2Style(){return Object.assign({borderBottomColor:this.color},this.circleStyle)}}},[["render",function(t,n,r,a,i,o){return(0,e.openBlock)(),(0,e.createElementBlock)("div",{class:"half-circle-spinner",style:(0,e.normalizeStyle)(o.spinnerStyle)},[(0,e.createElementVNode)("div",{class:"circle circle-1",style:(0,e.normalizeStyle)(o.circle1Style)},null,4),(0,e.createElementVNode)("div",{class:"circle circle-2",style:(0,e.normalizeStyle)(o.circle2Style)},null,4)],4)}]])},props:{verifyUrl:{type:String,default:function(){return null},required:!0},activateLicenseUrl:{type:String,default:function(){return null},required:!0},deactivateLicenseUrl:{type:String,default:function(){return null},required:!0},resetLicenseUrl:{type:String,default:function(){return null},required:!0},manageLicense:{type:String,default:function(){return"no"},required:!0}},data:function(){return{isLoading:!0,verified:!1,purchaseCode:null,buyer:null,licenseRulesAgreement:0,activating:!1,deactivating:!1,license:null}},mounted:function(){this.verifyLicense()},methods:{verifyLicense:function(){var e=this;axios.get(this.verifyUrl).then((function(t){t.data.error||(e.verified=!0,e.license=t.data.data),e.isLoading=!1})).catch((function(t){Botble.handleError(t.response.data),e.isLoading=!1}))},activateLicense:function(){var e=this;this.activating=!0,axios.post(this.activateLicenseUrl,{purchase_code:this.purchaseCode,buyer:this.buyer,license_rules_agreement:this.licenseRulesAgreement}).then((function(t){t.data.error?Botble.showError(t.data.message):(e.verified=!0,e.license=t.data.data,Botble.showSuccess(t.data.message)),e.activating=!1})).catch((function(t){Botble.handleError(t.response.data),e.activating=!1}))},deactivateLicense:function(){var e=this;this.deactivating=!0,axios.post(this.deactivateLicenseUrl).then((function(t){t.data.error?Botble.showError(t.data.message):e.verified=!1,e.deactivating=!1})).catch((function(t){Botble.handleError(t.response.data),e.deactivating=!1}))},resetLicense:function(){var e=this;this.deactivating=!0,axios.post(this.resetLicenseUrl,{purchase_code:this.purchaseCode,buyer:this.buyer,license_rules_agreement:this.licenseRulesAgreement}).then((function(t){if(t.data.error)return Botble.showError(t.data.message),e.deactivating=!1,!1;e.verified=!1,e.deactivating=!1,Botble.showSuccess(t.data.message)})).catch((function(t){Botble.handleError(t.response.data),e.deactivating=!1}))}}};const z=(0,n(3744).Z)(U,[["render",function(n,T,A,j,M,U){var z=(0,e.resolveComponent)("half-circle-spinner");return(0,e.openBlock)(),(0,e.createElementBlock)("div",t,[(0,e.createElementVNode)("div",r,[a,(0,e.createElementVNode)("div",i,[(0,e.createElementVNode)("div",o,[M.isLoading?((0,e.openBlock)(),(0,e.createElementBlock)("div",c,[(0,e.createVNode)(z,{"animation-duration":1e3,size:15,color:"#808080"})])):(0,e.createCommentVNode)("",!0),M.isLoading||M.verified?(0,e.createCommentVNode)("",!0):((0,e.openBlock)(),(0,e.createElementBlock)("div",l,[(0,e.createElementVNode)("div",s,["yes"===A.manageLicense?((0,e.openBlock)(),(0,e.createElementBlock)("p",d,"Your license is invalid. Please activate your license!")):(0,e.createCommentVNode)("",!0),"no"===A.manageLicense?((0,e.openBlock)(),(0,e.createElementBlock)("p",u,"You doesn't have permission to activate the license!")):(0,e.createCommentVNode)("",!0)]),(0,e.createElementVNode)("div",f,[m,(0,e.withDirectives)((0,e.createElementVNode)("input",{type:"text",class:"next-input","onUpdate:modelValue":T[0]||(T[0]=function(e){return M.buyer=e}),id:"buyer",placeholder:"Your Envato's username",disabled:"no"===A.manageLicense,readonly:"no"===A.manageLicense},null,8,p),[[e.vModelText,M.buyer]]),h]),(0,e.createElementVNode)("div",v,[b,(0,e.withDirectives)((0,e.createElementVNode)("input",{type:"text",class:"next-input","onUpdate:modelValue":T[1]||(T[1]=function(e){return M.purchaseCode=e}),id:"purchase_code",disabled:"no"===A.manageLicense,readonly:"no"===A.manageLicense,placeholder:"Ex: 10101010-10aa-0101-a1b1010a01b10"},null,8,g),[[e.vModelText,M.purchaseCode]])]),(0,e.createElementVNode)("div",y,[(0,e.createElementVNode)("label",null,[(0,e.withDirectives)((0,e.createElementVNode)("input",{type:"checkbox",name:"license_rules_agreement",value:"1","onUpdate:modelValue":T[2]||(T[2]=function(e){return M.licenseRulesAgreement=e}),disabled:"no"===A.manageLicense,readonly:"no"===A.manageLicense},null,8,E),[[e.vModelCheckbox,M.licenseRulesAgreement]]),(0,e.createTextVNode)("Confirm that, according to the Envato License Terms, each license entitles one person for a single project. Creating multiple unregistered installations is a copyright violation. "),N,(0,e.createTextVNode)(".")])]),(0,e.createElementVNode)("div",V,[(0,e.createElementVNode)("button",{class:(0,e.normalizeClass)(M.activating?"btn btn-info button-loading":"btn btn-info"),type:"button",disabled:"no"===A.manageLicense,onClick:T[3]||(T[3]=function(e){return U.activateLicense()})}," Activate license ",10,x),(0,e.createElementVNode)("button",{class:(0,e.normalizeClass)(M.deactivating?"btn btn-info button-loading ms-2":"btn btn-warning ms-2"),type:"button",disabled:"no"===A.manageLicense,onClick:T[4]||(T[4]=function(e){return U.resetLicense()})}," Reset license on this domain ",10,L)]),w,C])),!M.isLoading&&M.verified?((0,e.openBlock)(),(0,e.createElementBlock)("div",S,[(0,e.createElementVNode)("p",k," Licensed to "+(0,e.toDisplayString)(M.license.licensed_to)+". Activated since "+(0,e.toDisplayString)(M.license.activated_at)+". ",1),(0,e.createElementVNode)("div",B,[(0,e.createElementVNode)("button",{class:(0,e.normalizeClass)(M.deactivating?"btn btn-warning button-loading":"btn btn-warning"),type:"button",onClick:T[5]||(T[5]=function(e){return U.deactivateLicense()}),disabled:"no"===A.manageLicense}," Deactivate license ",10,_)])])):(0,e.createCommentVNode)("",!0)])])])])}]]);"undefined"!=typeof vueApp&&vueApp.booting((function(e){e.component("license-component",z)}))})()})();