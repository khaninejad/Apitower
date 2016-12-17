/*!
 * CSS Selector finder - v1.2.0
 * Made by @HashemQolami with care
 * Released under MIT license
 */
var CSSSF = (function(undefined) {
  "use strict";

  function isUnique(selector, contextNode) {
    return contextNode.querySelectorAll(selector).length === 1;
  }
  
  function realTypeOf(variable) {
    return Object.prototype.toString.call(variable).slice(1, -1).split(" ").pop().toLowerCase();
  }
  
  function nodeClasses(node) {
    return node.className.trim().replace(/\s+/g, '.');
  }
  
  function filterChildNodes(parentNode, fn) {
    var arr = [];
    Array.prototype.forEach.call(parentNode.children, function(node) {
      
      if (fn(node)) {
        arr.push(node);
      }
      
    });
    return arr;
  }

  function traverseDom(node, contextNode, unique) {
    var selector = [];

    while (node != contextNode) {
      var nodeName = node.nodeName.toLowerCase(),
          parentNode = node.parentNode,
          nthOfType = '';
      
      if (node.id) {
        selector.unshift([
          nodeName, '#', node.id
        ].join(''));
        break;
      }
      
      var className = nodeClasses(node);
      
      if (unique) {
        // filter childNodes to those have the same type of current node
        var
          nodesOfSameType = filterChildNodes(parentNode, function(node) {
            return node.nodeName.toLowerCase() === nodeName;
          }),
          nodesOfSameTypeAndClass = filterChildNodes(parentNode, function(node) {
            return node.nodeName.toLowerCase() === nodeName && nodeClasses(node) === className;
          }),
          nodeIndex = nodesOfSameType.indexOf(node);
        
        // if the current node is the only element of its type in the parent
        if (nodesOfSameTypeAndClass.length === 1) {
          nthOfType = '';
        } else {
          nthOfType = [
            ':nth-of-type(',
            nodeIndex + 1,
            ')'
          ].join('');
        }
      }
      
      if (className) {
        var classes = [
          '.',
          className,
          nthOfType,
        ].join('');

        selector.unshift([
          nodeName, classes
        ].join(''));

      } else {
        selector.unshift([
          nodeName,
          nthOfType
        ].join(''));
      }

      if (isUnique(selector.join(' > '), contextNode)) {
        break;
      }

      node = parentNode;
    }

    return selector.join(' > ');
  }
  
  return function(obj) {
    if (realTypeOf(obj) !== 'object') {
      throw new Error(obj + ' is not an object');
    }
    
    ['node', 'contextNode'].forEach(function(param) {
      if (! obj.hasOwnProperty(param)) {
        throw new Error(param + ' is missing in passed object');
      }
    });
    
    if (! obj.unique) {
      obj.unique = false;
    }
    
    return traverseDom(obj.node, obj.contextNode, obj.unique);
  };
}());


// demo
var allElements = document.querySelectorAll("body *");

Array.prototype.forEach.call(allElements, function(element) {
  element.addEventListener("mouseover", function(e) {
    e.stopPropagation();

    this.style.outline = "3px solid rgba(255, 140, 0, .8)";
  }, false);

  element.addEventListener("mouseout", function(e) {
    e.stopPropagation();

    this.style.outline = "none";
  }, false);

  element.addEventListener("click", function(e) {
    e.preventDefault();
    e.stopPropagation();

    var selector = CSSSF({
      node: e.target,
      contextNode: document.body,
      unique: true
    });

    // for demo
    console.log(selector);
	//parent.document.postMessage("Hello","selector");

	//var el = parent.document.getElementById("selected_option");
	//el.innerHTML = selector;
	parent.putdata(selector);
	// $(this).closest('li').find('input').focus();
	//parent.document.taggingDiv

    Array.prototype.forEach.call(allElements, function(elm) {
      elm.style.backgroundColor = "transparent";
      elm.style.boxShadow = "none";
    });

    this.style.backgroundColor = "rgba(255, 140, 0, .3)";
    this.style.boxShadow = "0 0 0 3px rgba(255, 140, 0, .3)";
  }, false);
});