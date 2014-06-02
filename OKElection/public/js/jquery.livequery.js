/*! Copyright (c) 2014 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt)
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){a.extend(a.fn,{livequery:function(b,c,d){var e=a.livequery.findorcreate(this,b,c,d);return e.run(),this},expire:function(b,c,d){var e=a.livequery.find(this,b,c,d);return e&&e.stop(),this}}),a.livequery=function(b,c,d,e){this.selector=c,this.jq=b,this.context=b.context,this.matchedFn=d,this.unmatchedFn=e,this.stopped=!1,this.id=a.livequery.queries.push(this)-1,d.$lqguid=d.$lqguid||a.livequery.guid++,e&&(e.$lqguid=e.$lqguid||a.livequery.guid++)},a.livequery.prototype={run:function(){this.stopped=!1,this.jq.find(this.selector).each(a.proxy(function(a,b){this.added(b)},this))},stop:function(){this.jq.find(this.selector).each(a.proxy(function(a,b){this.removed(b)},this)),this.stopped=!0},matches:function(b){return!this.isStopped()&&a(b,this.context).is(this.selector)&&this.jq.has(b).length},added:function(a){this.isStopped()||this.isMatched(a)||(this.markAsMatched(a),this.matchedFn.call(a,a))},removed:function(a){!this.isStopped()&&this.isMatched(a)&&(this.removeMatchedMark(a),this.unmatchedFn&&this.unmatchedFn.call(a,a))},getLQArray:function(b){var c=a.data(b,a.livequery.key)||[],d=a.inArray(this.id,c);return c.index=d,c},markAsMatched:function(b){var c=this.getLQArray(b);-1===c.index&&(c.push(this.id),a.data(b,a.livequery.key,c))},removeMatchedMark:function(b){var c=this.getLQArray(b);c.index>-1&&(c.splice(c.index,1),a.data(b,a.livequery.key,c))},isMatched:function(a){var b=this.getLQArray(a);return-1!==b.index},isStopped:function(){return this.stopped===!0}},a.extend(a.livequery,{version:"2.0.0-pre",guid:0,queries:[],watchAttributes:!0,attributeFilter:["class","className"],setup:!1,timeout:null,method:"none",prepared:!1,key:"livequery",htcPath:!1,prepare:{mutationobserver:function(){var b=new MutationObserver(a.livequery.handle.mutationobserver);b.observe(document,{childList:!0,attributes:a.livequery.watchAttributes,subtree:!0,attributeFilter:a.livequery.attributeFilter}),a.livequery.prepared=!0},mutationevent:function(){document.addEventListener("DOMNodeInserted",a.livequery.handle.mutationevent,!1),document.addEventListener("DOMNodeRemoved",a.livequery.handle.mutationevent,!1),a.livequery.watchAttributes&&document.addEventListener("DOMAttrModified",a.livequery.handle.mutationevent,!1),a.livequery.prepared=!0},iebehaviors:function(){a.livequery.htcPath&&(a("head").append("<style>body *{behavior:url("+a.livequery.htcPath+")}</style>"),a.livequery.prepared=!0)}},handle:{added:function(b){a.each(a.livequery.queries,function(a,c){c.matches(b)&&setTimeout(function(){c.added(b)},1)})},removed:function(b){a.each(a.livequery.queries,function(a,c){c.isMatched(b)&&setTimeout(function(){c.removed(b)},1)})},modified:function(b){a.each(a.livequery.queries,function(a,c){c.isMatched(b)?c.matches(b)||c.removed(b):c.matches(b)&&c.added(b)})},mutationevent:function(b){var c={DOMNodeInserted:"added",DOMNodeRemoved:"removed",DOMAttrModified:"modified"},d=c[b.type];"modified"===d?a.livequery.attributeFilter.indexOf(b.attrName)>-1&&a.livequery.handle.modified(b.target):a.livequery.handle[d](b.target)},mutationobserver:function(b){a.each(b,function(b,c){"attributes"===c.type?a.livequery.handle.modified(c.target):a.each(["added","removed"],function(b,d){a.each(c[d+"Nodes"],function(b,c){a.livequery.handle[d](c)})})})}},find:function(b,c,d,e){var f;return a.each(a.livequery.queries,function(a,g){return c!==g.selector||b!==g.jq||d&&d.$lqguid!==g.matchedFn.$lqguid||e&&e.$lqguid!==g.unmatchedFn.$lqguid?void 0:(f=g)&&!1}),f},findorcreate:function(b,c,d,e){return a.livequery.find(b,c,d,e)||new a.livequery(b,c,d,e)}}),a(function(){if("MutationObserver"in window?a.livequery.method="mutationobserver":"MutationEvent"in window?a.livequery.method="mutationevent":"behavior"in document.documentElement.currentStyle&&(a.livequery.method="iebehaviors"),!a.livequery.method)throw new Error("Could not find a means to monitor the DOM");a.livequery.prepare[a.livequery.method]()})});