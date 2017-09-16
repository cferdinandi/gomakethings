/*!
 * gomakethings v10.102.1: The WordPress theme for GoMakeThings.com
 * (c) 2017 Chris Ferdinandi
 * MIT License
 * https://github.com/cferdinandi/gomakethings
 * Open Source Credits: https://github.com/toddmotto/fluidvids, http://prismjs.com, https://github.com/muffinresearch/payment-icons, https://nosir.github.io/cleave.js/
 */

;(function (window, document, undefined) {

	'use strict';

	// Variables
	var buyNow = document.querySelectorAll('.edd-buy-now-button');

	// Handle "buy now" clicks
	var buyNowHandler = function (event) {
		if (!event.target.classList.contains('edd-buy-now-button')) return;
		event.target.innerHTML = 'Adding to cart...';
		event.target.classList.add('disabled');
	};

	// Listen for "buy now" clicks
	if (buyNow.length > 0) {
		document.addEventListener('click', buyNowHandler, false);
	}

})(window, document);
// JavaScript enabled
document.documentElement.className += ' js-edd';
/**
 * Prepopulate email fields based on a query string
 */
;(function (window, document, undefined) {

	'use strict';

	// Feature Test
	var supports = 'querySelector' in document;
	if ( !supports ) return;

	/**
	 * Get the value of a query string from a URL
	 * @param  {String} field The field to get the value of
	 * @param  {String} url   The URL to get the value from [optional]
	 * @return {String}       The value
	 */
	var getQueryString = function ( field, url ) {
		var href = url ? url : window.location.href;
		var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
		var string = reg.exec(href);
		return string ? string[1] : null;
	};

	// Variables
	var email = getQueryString('email');
	var input = document.querySelector('input[type="email"]');
	if (!email || !input) return;

	// Autoload email
	input.value = email;

})(window, document);
/*! fluidvids.js v2.4.1 | (c) 2014 @toddmotto | https://github.com/toddmotto/fluidvids */
(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(factory);
  } else if (typeof exports === 'object') {
    module.exports = factory;
  } else {
    root.fluidvids = factory();
  }
})(this, (function () {

  'use strict';

  var fluidvids = {
    selector: ['iframe'],
    players: ['www.youtube.com', 'player.vimeo.com']
  };

  var css = [
    '.fluidvids {',
      'width: 100%; max-width: 100%; position: relative;',
    '}',
    '.fluidvids-item {',
      'position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;',
    '}'
  ].join('');

  var head = document.head || document.getElementsByTagName('head')[0];

  var matches = function (src) {
    return new RegExp('^(https?:)?\/\/(?:' + fluidvids.players.join('|') + ').*$', 'i').test(src);
  };

  var getRatio = function (height, width) {
    return ((parseInt(height, 10) / parseInt(width, 10)) * 100) + '%';
  };

  var fluid = function (elem) {
    if (!matches(elem.src) || !!elem.getAttribute('data-fluidvids')) return;
    var wrap = document.createElement('div');
    elem.parentNode.insertBefore(wrap, elem);
    elem.className += (elem.className ? ' ' : '') + 'fluidvids-item';
    elem.setAttribute('data-fluidvids', 'loaded');
    wrap.className += 'fluidvids';
    wrap.style.paddingTop = getRatio(elem.height, elem.width);
    wrap.appendChild(elem);
  };

  var addStyles = function () {
    var div = document.createElement('div');
    div.innerHTML = '<p>x</p><style>' + css + '</style>';
    head.appendChild(div.childNodes[1]);
  };

  fluidvids.render = function () {
    var nodes = document.querySelectorAll(fluidvids.selector.join());
    var i = nodes.length;
    while (i--) {
      fluid(nodes[i]);
    }
  };

  fluidvids.init = function (obj) {
    for (var key in obj) {
      fluidvids[key] = obj[key];
    }
    fluidvids.render();
    addStyles();
  };

  return fluidvids;

}));
/* http://prismjs.com/download.html?themes=prism&languages=markup+css+clike+javascript+bash+css-extras+php+php-extras+scss */
/* jshint ignore:start */
var _self = (typeof window !== 'undefined')
	? window   // if in browser
	: (
		(typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
			? self // if in worker
			: {}   // if in node js
	);

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 * MIT license http://www.opensource.org/licenses/mit-license.php/
 * @author Lea Verou http://lea.verou.me
 */

var Prism = (function () {

	// Private helper vars
	var lang = /\blang(?:uage)?-(\w+)\b/i;
	var uniqueId = 0;

	var _ = _self.Prism = {
		manual: _self.Prism && _self.Prism.manual,
		util: {
			encode: function (tokens) {
				if (tokens instanceof Token) {
					return new Token(tokens.type, _.util.encode(tokens.content), tokens.alias);
				} else if (_.util.type(tokens) === 'Array') {
					return tokens.map(_.util.encode);
				} else {
					return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
				}
			},

			type: function (o) {
				return Object.prototype.toString.call(o).match(/\[object (\w+)\]/)[1];
			},

			objId: function (obj) {
				if (!obj['__id']) {
					Object.defineProperty(obj, '__id', { value: ++uniqueId });
				}
				return obj['__id'];
			},

			// Deep clone a language definition (e.g. to extend it)
			clone: function (o) {
				var type = _.util.type(o);

				switch (type) {
					case 'Object':
						var clone = {};

						for (var key in o) {
							if (o.hasOwnProperty(key)) {
								clone[key] = _.util.clone(o[key]);
							}
						}

						return clone;

					case 'Array':
						// Check for existence for IE8
						return o.map && o.map((function (v) { return _.util.clone(v); }));
				}

				return o;
			}
		},

		languages: {
			extend: function (id, redef) {
				var lang = _.util.clone(_.languages[id]);

				for (var key in redef) {
					lang[key] = redef[key];
				}

				return lang;
			},

			/**
			 * Insert a token before another token in a language literal
			 * As this needs to recreate the object (we cannot actually insert before keys in object literals),
			 * we cannot just provide an object, we need anobject and a key.
			 * @param inside The key (or language id) of the parent
			 * @param before The key to insert before. If not provided, the function appends instead.
			 * @param insert Object with the key/value pairs to insert
			 * @param root The object that contains `inside`. If equal to Prism.languages, it can be omitted.
			 */
			insertBefore: function (inside, before, insert, root) {
				root = root || _.languages;
				var grammar = root[inside];

				if (arguments.length == 2) {
					insert = arguments[1];

					for (var newToken in insert) {
						if (insert.hasOwnProperty(newToken)) {
							grammar[newToken] = insert[newToken];
						}
					}

					return grammar;
				}

				var ret = {};

				for (var token in grammar) {

					if (grammar.hasOwnProperty(token)) {

						if (token == before) {

							for (var newToken in insert) {

								if (insert.hasOwnProperty(newToken)) {
									ret[newToken] = insert[newToken];
								}
							}
						}

						ret[token] = grammar[token];
					}
				}

				// Update references in other language definitions
				_.languages.DFS(_.languages, (function (key, value) {
					if (value === root[inside] && key != inside) {
						this[key] = ret;
					}
				}));

				return root[inside] = ret;
			},

			// Traverse a language definition with Depth First Search
			DFS: function (o, callback, type, visited) {
				visited = visited || {};
				for (var i in o) {
					if (o.hasOwnProperty(i)) {
						callback.call(o, i, o[i], type || i);

						if (_.util.type(o[i]) === 'Object' && !visited[_.util.objId(o[i])]) {
							visited[_.util.objId(o[i])] = true;
							_.languages.DFS(o[i], callback, null, visited);
						}
						else if (_.util.type(o[i]) === 'Array' && !visited[_.util.objId(o[i])]) {
							visited[_.util.objId(o[i])] = true;
							_.languages.DFS(o[i], callback, i, visited);
						}
					}
				}
			}
		},
		plugins: {},

		highlightAll: function (async, callback) {
			var env = {
				callback: callback,
				selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
			};

			_.hooks.run("before-highlightall", env);

			var elements = env.elements || document.querySelectorAll(env.selector);

			for (var i = 0, element; element = elements[i++];) {
				_.highlightElement(element, async === true, env.callback);
			}
		},

		highlightElement: function (element, async, callback) {
			// Find language
			var language, grammar, parent = element;

			while (parent && !lang.test(parent.className)) {
				parent = parent.parentNode;
			}

			if (parent) {
				language = (parent.className.match(lang) || [, ''])[1].toLowerCase();
				grammar = _.languages[language];
			}

			// Set language on the element, if not present
			element.className = element.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;

			// Set language on the parent, for styling
			parent = element.parentNode;

			if (/pre/i.test(parent.nodeName)) {
				parent.className = parent.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;
			}

			var code = element.textContent;

			var env = {
				element: element,
				language: language,
				grammar: grammar,
				code: code
			};

			_.hooks.run('before-sanity-check', env);

			if (!env.code || !env.grammar) {
				if (env.code) {
					_.hooks.run('before-highlight', env);
					env.element.textContent = env.code;
					_.hooks.run('after-highlight', env);
				}
				_.hooks.run('complete', env);
				return;
			}

			_.hooks.run('before-highlight', env);

			if (async && _self.Worker) {
				var worker = new Worker(_.filename);

				worker.onmessage = function (evt) {
					env.highlightedCode = evt.data;

					_.hooks.run('before-insert', env);

					env.element.innerHTML = env.highlightedCode;

					callback && callback.call(env.element);
					_.hooks.run('after-highlight', env);
					_.hooks.run('complete', env);
				};

				worker.postMessage(JSON.stringify({
					language: env.language,
					code: env.code,
					immediateClose: true
				}));
			}
			else {
				env.highlightedCode = _.highlight(env.code, env.grammar, env.language);

				_.hooks.run('before-insert', env);

				env.element.innerHTML = env.highlightedCode;

				callback && callback.call(element);

				_.hooks.run('after-highlight', env);
				_.hooks.run('complete', env);
			}
		},

		highlight: function (text, grammar, language) {
			var tokens = _.tokenize(text, grammar);
			return Token.stringify(_.util.encode(tokens), language);
		},

		matchGrammar: function (text, strarr, grammar, index, startPos, oneshot, target) {
			var Token = _.Token;

			for (var token in grammar) {
				if (!grammar.hasOwnProperty(token) || !grammar[token]) {
					continue;
				}

				if (token == target) {
					return;
				}

				var patterns = grammar[token];
				patterns = (_.util.type(patterns) === "Array") ? patterns : [patterns];

				for (var j = 0; j < patterns.length; ++j) {
					var pattern = patterns[j],
						inside = pattern.inside,
						lookbehind = !!pattern.lookbehind,
						greedy = !!pattern.greedy,
						lookbehindLength = 0,
						alias = pattern.alias;

					if (greedy && !pattern.pattern.global) {
						// Without the global flag, lastIndex won't work
						var flags = pattern.pattern.toString().match(/[imuy]*$/)[0];
						pattern.pattern = RegExp(pattern.pattern.source, flags + "g");
					}

					pattern = pattern.pattern || pattern;

					// Don’t cache length as it changes during the loop
					for (var i = index, pos = startPos; i < strarr.length; pos += strarr[i].length, ++i) {

						var str = strarr[i];

						if (strarr.length > text.length) {
							// Something went terribly wrong, ABORT, ABORT!
							return;
						}

						if (str instanceof Token) {
							continue;
						}

						pattern.lastIndex = 0;

						var match = pattern.exec(str),
							delNum = 1;

						// Greedy patterns can override/remove up to two previously matched tokens
						if (!match && greedy && i != strarr.length - 1) {
							pattern.lastIndex = pos;
							match = pattern.exec(text);
							if (!match) {
								break;
							}

							var from = match.index + (lookbehind ? match[1].length : 0),
								to = match.index + match[0].length,
								k = i,
								p = pos;

							for (var len = strarr.length; k < len && (p < to || (!strarr[k].type && !strarr[k - 1].greedy)); ++k) {
								p += strarr[k].length;
								// Move the index i to the element in strarr that is closest to from
								if (from >= p) {
									++i;
									pos = p;
								}
							}

							/*
							 * If strarr[i] is a Token, then the match starts inside another Token, which is invalid
							 * If strarr[k - 1] is greedy we are in conflict with another greedy pattern
							 */
							if (strarr[i] instanceof Token || strarr[k - 1].greedy) {
								continue;
							}

							// Number of tokens to delete and replace with the new match
							delNum = k - i;
							str = text.slice(pos, p);
							match.index -= pos;
						}

						if (!match) {
							if (oneshot) {
								break;
							}

							continue;
						}

						if (lookbehind) {
							lookbehindLength = match[1].length;
						}

						var from = match.index + lookbehindLength,
							match = match[0].slice(lookbehindLength),
							to = from + match.length,
							before = str.slice(0, from),
							after = str.slice(to);

						var args = [i, delNum];

						if (before) {
							++i;
							pos += before.length;
							args.push(before);
						}

						var wrapped = new Token(token, inside ? _.tokenize(match, inside) : match, alias, match, greedy);

						args.push(wrapped);

						if (after) {
							args.push(after);
						}

						Array.prototype.splice.apply(strarr, args);

						if (delNum != 1)
							_.matchGrammar(text, strarr, grammar, i, pos, true, token);

						if (oneshot)
							break;
					}
				}
			}
		},

		tokenize: function (text, grammar, language) {
			var strarr = [text];

			var rest = grammar.rest;

			if (rest) {
				for (var token in rest) {
					grammar[token] = rest[token];
				}

				delete grammar.rest;
			}

			_.matchGrammar(text, strarr, grammar, 0, 0, false);

			return strarr;
		},

		hooks: {
			all: {},

			add: function (name, callback) {
				var hooks = _.hooks.all;

				hooks[name] = hooks[name] || [];

				hooks[name].push(callback);
			},

			run: function (name, env) {
				var callbacks = _.hooks.all[name];

				if (!callbacks || !callbacks.length) {
					return;
				}

				for (var i = 0, callback; callback = callbacks[i++];) {
					callback(env);
				}
			}
		}
	};

	var Token = _.Token = function (type, content, alias, matchedStr, greedy) {
		this.type = type;
		this.content = content;
		this.alias = alias;
		// Copy of the full string this token was created from
		this.length = (matchedStr || "").length | 0;
		this.greedy = !!greedy;
	};

	Token.stringify = function (o, language, parent) {
		if (typeof o == 'string') {
			return o;
		}

		if (_.util.type(o) === 'Array') {
			return o.map((function (element) {
				return Token.stringify(element, language, o);
			})).join('');
		}

		var env = {
			type: o.type,
			content: Token.stringify(o.content, language, parent),
			tag: 'span',
			classes: ['token', o.type],
			attributes: {},
			language: language,
			parent: parent
		};

		if (env.type == 'comment') {
			env.attributes['spellcheck'] = 'true';
		}

		if (o.alias) {
			var aliases = _.util.type(o.alias) === 'Array' ? o.alias : [o.alias];
			Array.prototype.push.apply(env.classes, aliases);
		}

		_.hooks.run('wrap', env);

		var attributes = Object.keys(env.attributes).map((function (name) {
			return name + '="' + (env.attributes[name] || '').replace(/"/g, '&quot;') + '"';
		})).join(' ');

		return '<' + env.tag + ' class="' + env.classes.join(' ') + '"' + (attributes ? ' ' + attributes : '') + '>' + env.content + '</' + env.tag + '>';

	};

	if (!_self.document) {
		if (!_self.addEventListener) {
			// in Node.js
			return _self.Prism;
		}
		// In worker
		_self.addEventListener('message', (function (evt) {
			var message = JSON.parse(evt.data),
				lang = message.language,
				code = message.code,
				immediateClose = message.immediateClose;

			_self.postMessage(_.highlight(code, _.languages[lang], lang));
			if (immediateClose) {
				_self.close();
			}
		}), false);

		return _self.Prism;
	}

	//Get current script and highlight
	var script = document.currentScript || [].slice.call(document.getElementsByTagName("script")).pop();

	if (script) {
		_.filename = script.src;

		if (document.addEventListener && !_.manual && !script.hasAttribute('data-manual')) {
			if (document.readyState !== "loading") {
				if (window.requestAnimationFrame) {
					window.requestAnimationFrame(_.highlightAll);
				} else {
					window.setTimeout(_.highlightAll, 16);
				}
			}
			else {
				document.addEventListener('DOMContentLoaded', _.highlightAll);
			}
		}
	}

	return _self.Prism;

})();

if (typeof module !== 'undefined' && module.exports) {
	module.exports = Prism;
}

// hack for components to work correctly in node.js
if (typeof global !== 'undefined') {
	global.Prism = Prism;
}
;
Prism.languages.markup = {
	'comment': /<!--[\s\S]*?-->/,
	'prolog': /<\?[\s\S]+?\?>/,
	'doctype': /<!DOCTYPE[\s\S]+?>/i,
	'cdata': /<!\[CDATA\[[\s\S]*?]]>/i,
	'tag': {
		pattern: /<\/?(?!\d)[^\s>\/=$<]+(?:\s+[^\s>\/=]+(?:=(?:("|')(?:\\\1|\\?(?!\1)[\s\S])*\1|[^\s'">=]+))?)*\s*\/?>/i,
		inside: {
			'tag': {
				pattern: /^<\/?[^\s>\/]+/i,
				inside: {
					'punctuation': /^<\/?/,
					'namespace': /^[^\s>\/:]+:/
				}
			},
			'attr-value': {
				pattern: /=(?:('|")[\s\S]*?(\1)|[^\s>]+)/i,
				inside: {
					'punctuation': /[=>"']/
				}
			},
			'punctuation': /\/?>/,
			'attr-name': {
				pattern: /[^\s>\/]+/,
				inside: {
					'namespace': /^[^\s>\/:]+:/
				}
			}

		}
	},
	'entity': /&#?[\da-z]{1,8};/i
};

Prism.languages.markup['tag'].inside['attr-value'].inside['entity'] =
	Prism.languages.markup['entity'];

// Plugin to make entity title show the real entity, idea by Roman Komarov
Prism.hooks.add('wrap', (function (env) {

	if (env.type === 'entity') {
		env.attributes['title'] = env.content.replace(/&amp;/, '&');
	}
}));

Prism.languages.xml = Prism.languages.markup;
Prism.languages.html = Prism.languages.markup;
Prism.languages.mathml = Prism.languages.markup;
Prism.languages.svg = Prism.languages.markup;

Prism.languages.css = {
	'comment': /\/\*[\s\S]*?\*\//,
	'atrule': {
		pattern: /@[\w-]+?.*?(;|(?=\s*\{))/i,
		inside: {
			'rule': /@[\w-]+/
			// See rest below
		}
	},
	'url': /url\((?:(["'])(\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1|.*?)\)/i,
	'selector': /[^\{\}\s][^\{\};]*?(?=\s*\{)/,
	'string': {
		pattern: /("|')(\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'property': /(\b|\B)[\w-]+(?=\s*:)/i,
	'important': /\B!important\b/i,
	'function': /[-a-z0-9]+(?=\()/i,
	'punctuation': /[(){};:]/
};

Prism.languages.css['atrule'].inside.rest = Prism.util.clone(Prism.languages.css);

if (Prism.languages.markup) {
	Prism.languages.insertBefore('markup', 'tag', {
		'style': {
			pattern: /(<style[\s\S]*?>)[\s\S]*?(?=<\/style>)/i,
			lookbehind: true,
			inside: Prism.languages.css,
			alias: 'language-css'
		}
	});

	Prism.languages.insertBefore('inside', 'attr-value', {
		'style-attr': {
			pattern: /\s*style=("|').*?\1/i,
			inside: {
				'attr-name': {
					pattern: /^\s*style/i,
					inside: Prism.languages.markup.tag.inside
				},
				'punctuation': /^\s*=\s*['"]|['"]\s*$/,
				'attr-value': {
					pattern: /.+/i,
					inside: Prism.languages.css
				}
			},
			alias: 'language-css'
		}
	}, Prism.languages.markup.tag);
};
Prism.languages.clike = {
	'comment': [
		{
			pattern: /(^|[^\\])\/\*[\s\S]*?\*\//,
			lookbehind: true
		},
		{
			pattern: /(^|[^\\:])\/\/.*/,
			lookbehind: true
		}
	],
	'string': {
		pattern: /(["'])(\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/,
		greedy: true
	},
	'class-name': {
		pattern: /((?:\b(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\]+/i,
		lookbehind: true,
		inside: {
			punctuation: /(\.|\\)/
		}
	},
	'keyword': /\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,
	'boolean': /\b(true|false)\b/,
	'function': /[a-z0-9_]+(?=\()/i,
	'number': /\b-?(?:0x[\da-f]+|\d*\.?\d+(?:e[+-]?\d+)?)\b/i,
	'operator': /--?|\+\+?|!=?=?|<=?|>=?|==?=?|&&?|\|\|?|\?|\*|\/|~|\^|%/,
	'punctuation': /[{}[\];(),.:]/
};

Prism.languages.javascript = Prism.languages.extend('clike', {
	'keyword': /\b(as|async|await|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|get|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|set|static|super|switch|this|throw|try|typeof|var|void|while|with|yield)\b/,
	'number': /\b-?(0[xX][\dA-Fa-f]+|0[bB][01]+|0[oO][0-7]+|\d*\.?\d+([Ee][+-]?\d+)?|NaN|Infinity)\b/,
	// Allow for all non-ASCII characters (See http://stackoverflow.com/a/2008444)
	'function': /[_$a-zA-Z\xA0-\uFFFF][_$a-zA-Z0-9\xA0-\uFFFF]*(?=\()/i,
	'operator': /-[-=]?|\+[+=]?|!=?=?|<<?=?|>>?>?=?|=(?:==?|>)?|&[&=]?|\|[|=]?|\*\*?=?|\/=?|~|\^=?|%=?|\?|\.{3}/
});

Prism.languages.insertBefore('javascript', 'keyword', {
	'regex': {
		pattern: /(^|[^/])\/(?!\/)(\[[^\]\r\n]+]|\\.|[^/\\\[\r\n])+\/[gimyu]{0,5}(?=\s*($|[\r\n,.;})]))/,
		lookbehind: true,
		greedy: true
	}
});

Prism.languages.insertBefore('javascript', 'string', {
	'template-string': {
		pattern: /`(?:\\\\|\\?[^\\])*?`/,
		greedy: true,
		inside: {
			'interpolation': {
				pattern: /\$\{[^}]+\}/,
				inside: {
					'interpolation-punctuation': {
						pattern: /^\$\{|\}$/,
						alias: 'punctuation'
					},
					rest: Prism.languages.javascript
				}
			},
			'string': /[\s\S]+/
		}
	}
});

if (Prism.languages.markup) {
	Prism.languages.insertBefore('markup', 'tag', {
		'script': {
			pattern: /(<script[\s\S]*?>)[\s\S]*?(?=<\/script>)/i,
			lookbehind: true,
			inside: Prism.languages.javascript,
			alias: 'language-javascript'
		}
	});
}

Prism.languages.js = Prism.languages.javascript;

(function (Prism) {
	var insideString = {
		variable: [
			// Arithmetic Environment
			{
				pattern: /\$?\(\([\s\S]+?\)\)/,
				inside: {
					// If there is a $ sign at the beginning highlight $(( and )) as variable
					variable: [{
						pattern: /(^\$\(\([\s\S]+)\)\)/,
						lookbehind: true
					},
						/^\$\(\(/,
					],
					number: /\b-?(?:0x[\dA-Fa-f]+|\d*\.?\d+(?:[Ee]-?\d+)?)\b/,
					// Operators according to https://www.gnu.org/software/bash/manual/bashref.html#Shell-Arithmetic
					operator: /--?|-=|\+\+?|\+=|!=?|~|\*\*?|\*=|\/=?|%=?|<<=?|>>=?|<=?|>=?|==?|&&?|&=|\^=?|\|\|?|\|=|\?|:/,
					// If there is no $ sign at the beginning highlight (( and )) as punctuation
					punctuation: /\(\(?|\)\)?|,|;/
				}
			},
			// Command Substitution
			{
				pattern: /\$\([^)]+\)|`[^`]+`/,
				inside: {
					variable: /^\$\(|^`|\)$|`$/
				}
			},
			/\$(?:[a-z0-9_#\?\*!@]+|\{[^}]+\})/i
		],
	};

	Prism.languages.bash = {
		'shebang': {
			pattern: /^#!\s*\/bin\/bash|^#!\s*\/bin\/sh/,
			alias: 'important'
		},
		'comment': {
			pattern: /(^|[^"{\\])#.*/,
			lookbehind: true
		},
		'string': [
			//Support for Here-Documents https://en.wikipedia.org/wiki/Here_document
			{
				pattern: /((?:^|[^<])<<\s*)(?:"|')?(\w+?)(?:"|')?\s*\r?\n(?:[\s\S])*?\r?\n\2/g,
				lookbehind: true,
				greedy: true,
				inside: insideString
			},
			{
				pattern: /(["'])(?:\\\\|\\?[^\\])*?\1/g,
				greedy: true,
				inside: insideString
			}
		],
		'variable': insideString.variable,
		// Originally based on http://ss64.com/bash/
		'function': {
			pattern: /(^|\s|;|\||&)(?:alias|apropos|apt-get|aptitude|aspell|awk|basename|bash|bc|bg|builtin|bzip2|cal|cat|cd|cfdisk|chgrp|chmod|chown|chroot|chkconfig|cksum|clear|cmp|comm|command|cp|cron|crontab|csplit|cut|date|dc|dd|ddrescue|df|diff|diff3|dig|dir|dircolors|dirname|dirs|dmesg|du|egrep|eject|enable|env|ethtool|eval|exec|expand|expect|export|expr|fdformat|fdisk|fg|fgrep|file|find|fmt|fold|format|free|fsck|ftp|fuser|gawk|getopts|git|grep|groupadd|groupdel|groupmod|groups|gzip|hash|head|help|hg|history|hostname|htop|iconv|id|ifconfig|ifdown|ifup|import|install|jobs|join|kill|killall|less|link|ln|locate|logname|logout|look|lpc|lpr|lprint|lprintd|lprintq|lprm|ls|lsof|make|man|mkdir|mkfifo|mkisofs|mknod|more|most|mount|mtools|mtr|mv|mmv|nano|netstat|nice|nl|nohup|notify-send|npm|nslookup|open|op|passwd|paste|pathchk|ping|pkill|popd|pr|printcap|printenv|printf|ps|pushd|pv|pwd|quota|quotacheck|quotactl|ram|rar|rcp|read|readarray|readonly|reboot|rename|renice|remsync|rev|rm|rmdir|rsync|screen|scp|sdiff|sed|seq|service|sftp|shift|shopt|shutdown|sleep|slocate|sort|source|split|ssh|stat|strace|su|sudo|sum|suspend|sync|tail|tar|tee|test|time|timeout|times|touch|top|traceroute|trap|tr|tsort|tty|type|ulimit|umask|umount|unalias|uname|unexpand|uniq|units|unrar|unshar|uptime|useradd|userdel|usermod|users|uuencode|uudecode|v|vdir|vi|vmstat|wait|watch|wc|wget|whereis|which|who|whoami|write|xargs|xdg-open|yes|zip)(?=$|\s|;|\||&)/,
			lookbehind: true
		},
		'keyword': {
			pattern: /(^|\s|;|\||&)(?:let|:|\.|if|then|else|elif|fi|for|break|continue|while|in|case|function|select|do|done|until|echo|exit|return|set|declare)(?=$|\s|;|\||&)/,
			lookbehind: true
		},
		'boolean': {
			pattern: /(^|\s|;|\||&)(?:true|false)(?=$|\s|;|\||&)/,
			lookbehind: true
		},
		'operator': /&&?|\|\|?|==?|!=?|<<<?|>>|<=?|>=?|=~/,
		'punctuation': /\$?\(\(?|\)\)?|\.\.|[{}[\];]/
	};

	var inside = insideString.variable[1].inside;
	inside['function'] = Prism.languages.bash['function'];
	inside.keyword = Prism.languages.bash.keyword;
	inside.boolean = Prism.languages.bash.boolean;
	inside.operator = Prism.languages.bash.operator;
	inside.punctuation = Prism.languages.bash.punctuation;
})(Prism);

Prism.languages.css.selector = {
	pattern: /[^\{\}\s][^\{\}]*(?=\s*\{)/,
	inside: {
		'pseudo-element': /:(?:after|before|first-letter|first-line|selection)|::[-\w]+/,
		'pseudo-class': /:[-\w]+(?:\(.*\))?/,
		'class': /\.[-:\.\w]+/,
		'id': /#[-:\.\w]+/,
		'attribute': /\[[^\]]+\]/
	}
};

Prism.languages.insertBefore('css', 'function', {
	'hexcode': /#[\da-f]{3,8}/i,
	'entity': /\\[\da-f]{1,8}/i,
	'number': /[\d%\.]+/
});
/**
 * Original by Aaron Harun: http://aahacreative.com/2012/07/31/php-syntax-highlighting-prism/
 * Modified by Miles Johnson: http://milesj.me
 *
 * Supports the following:
 * 		- Extends clike syntax
 * 		- Support for PHP 5.3+ (namespaces, traits, generators, etc)
 * 		- Smarter constant and function matching
 *
 * Adds the following new token classes:
 * 		constant, delimiter, variable, function, package
 */

Prism.languages.php = Prism.languages.extend('clike', {
	'keyword': /\b(and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i,
	'constant': /\b[A-Z0-9_]{2,}\b/,
	'comment': {
		pattern: /(^|[^\\])(?:\/\*[\s\S]*?\*\/|\/\/.*)/,
		lookbehind: true
	}
});

// Shell-like comments are matched after strings, because they are less
// common than strings containing hashes...
Prism.languages.insertBefore('php', 'class-name', {
	'shell-comment': {
		pattern: /(^|[^\\])#.*/,
		lookbehind: true,
		alias: 'comment'
	}
});

Prism.languages.insertBefore('php', 'keyword', {
	'delimiter': {
		pattern: /\?>|<\?(?:php|=)?/i,
		alias: 'important'
	},
	'variable': /\$\w+\b/i,
	'package': {
		pattern: /(\\|namespace\s+|use\s+)[\w\\]+/,
		lookbehind: true,
		inside: {
			punctuation: /\\/
		}
	}
});

// Must be defined after the function pattern
Prism.languages.insertBefore('php', 'operator', {
	'property': {
		pattern: /(->)[\w]+/,
		lookbehind: true
	}
});

// Add HTML support if the markup language exists
if (Prism.languages.markup) {

	// Tokenize all inline PHP blocks that are wrapped in <?php ?>
	// This allows for easy PHP + markup highlighting
	Prism.hooks.add('before-highlight', (function (env) {
		if (env.language !== 'php' || !/(?:<\?php|<\?)/ig.test(env.code)) {
			return;
		}

		env.tokenStack = [];

		env.backupCode = env.code;
		env.code = env.code.replace(/(?:<\?php|<\?)[\s\S]*?(?:\?>|$)/ig, (function (match) {
			var i = env.tokenStack.length;
			// Check for existing strings
			while (env.backupCode.indexOf('___PHP' + i + '___') !== -1)
				++i;

			// Create a sparse array
			env.tokenStack[i] = match;

			return '___PHP' + i + '___';
		}));

		// Switch the grammar to markup
		env.grammar = Prism.languages.markup;
	}));

	// Restore env.code for other plugins (e.g. line-numbers)
	Prism.hooks.add('before-insert', (function (env) {
		if (env.language === 'php' && env.backupCode) {
			env.code = env.backupCode;
			delete env.backupCode;
		}
	}));

	// Re-insert the tokens after highlighting
	Prism.hooks.add('after-highlight', (function (env) {
		if (env.language !== 'php' || !env.tokenStack) {
			return;
		}

		// Switch the grammar back
		env.grammar = Prism.languages.php;

		for (var i = 0, keys = Object.keys(env.tokenStack); i < keys.length; ++i) {
			var k = keys[i];
			var t = env.tokenStack[k];

			// The replace prevents $$, $&, $`, $', $n, $nn from being interpreted as special patterns
			env.highlightedCode = env.highlightedCode.replace('___PHP' + k + '___',
				"<span class=\"token php language-php\">" +
				Prism.highlight(t, env.grammar, 'php').replace(/\$/g, '$$$$') +
				"</span>");
		}

		env.element.innerHTML = env.highlightedCode;
	}));
}
;
Prism.languages.insertBefore('php', 'variable', {
	'this': /\$this\b/,
	'global': /\$(?:_(?:SERVER|GET|POST|FILES|REQUEST|SESSION|ENV|COOKIE)|GLOBALS|HTTP_RAW_POST_DATA|argc|argv|php_errormsg|http_response_header)/,
	'scope': {
		pattern: /\b[\w\\]+::/,
		inside: {
			keyword: /(static|self|parent)/,
			punctuation: /(::|\\)/
		}
	}
});
Prism.languages.scss = Prism.languages.extend('css', {
	'comment': {
		pattern: /(^|[^\\])(?:\/\*[\s\S]*?\*\/|\/\/.*)/,
		lookbehind: true
	},
	'atrule': {
		pattern: /@[\w-]+(?:\([^()]+\)|[^(])*?(?=\s+[{;])/,
		inside: {
			'rule': /@[\w-]+/
			// See rest below
		}
	},
	// url, compassified
	'url': /(?:[-a-z]+-)*url(?=\()/i,
	// CSS selector regex is not appropriate for Sass
	// since there can be lot more things (var, @ directive, nesting..)
	// a selector must start at the end of a property or after a brace (end of other rules or nesting)
	// it can contain some characters that aren't used for defining rules or end of selector, & (parent selector), or interpolated variable
	// the end of a selector is found when there is no rules in it ( {} or {\s}) or if there is a property (because an interpolated var
	// can "pass" as a selector- e.g: proper#{$erty})
	// this one was hard to do, so please be careful if you edit this one :)
	'selector': {
		// Initial look-ahead is used to prevent matching of blank selectors
		pattern: /(?=\S)[^@;\{\}\(\)]?([^@;\{\}\(\)]|&|#\{\$[-_\w]+\})+(?=\s*\{(\}|\s|[^\}]+(:|\{)[^\}]+))/m,
		inside: {
			'parent': {
				pattern: /&/,
				alias: 'important'
			},
			'placeholder': /%[-_\w]+/,
			'variable': /\$[-_\w]+|#\{\$[-_\w]+\}/
		}
	}
});

Prism.languages.insertBefore('scss', 'atrule', {
	'keyword': [
		/@(?:if|else(?: if)?|for|each|while|import|extend|debug|warn|mixin|include|function|return|content)/i,
		{
			pattern: /( +)(?:from|through)(?= )/,
			lookbehind: true
		}
	]
});

Prism.languages.scss.property = {
	pattern: /(?:[\w-]|\$[-_\w]+|#\{\$[-_\w]+\})+(?=\s*:)/i,
	inside: {
		'variable': /\$[-_\w]+|#\{\$[-_\w]+\}/
	}
};

Prism.languages.insertBefore('scss', 'important', {
	// var and interpolated vars
	'variable': /\$[-_\w]+|#\{\$[-_\w]+\}/
});

Prism.languages.insertBefore('scss', 'function', {
	'placeholder': {
		pattern: /%[-_\w]+/,
		alias: 'selector'
	},
	'statement': {
		pattern: /\B!(?:default|optional)\b/i,
		alias: 'keyword'
	},
	'boolean': /\b(?:true|false)\b/,
	'null': /\bnull\b/,
	'operator': {
		pattern: /(\s)(?:[-+*\/%]|[=!]=|<=?|>=?|and|or|not)(?=\s)/,
		lookbehind: true
	}
});

Prism.languages.scss['atrule'].inside.rest = Prism.util.clone(Prism.languages.scss);
/* jshint ignore:end */
/*!
 * smooth-scroll v11.1.0: Animate scrolling to anchor links
 * (c) 2017 Chris Ferdinandi
 * GPL-3.0 License
 * http://github.com/cferdinandi/smooth-scroll
 */

(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define([], factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.smoothScroll = factory(root);
	}
})(typeof global !== 'undefined' ? global : this.window || this.global, (function (root) {

	'use strict';

	//
	// Variables
	//

	var smoothScroll = {}; // Object for public APIs
	var supports = 'querySelector' in document && 'addEventListener' in root; // Feature test
	var settings, anchor, toggle, fixedHeader, headerHeight, eventTimeout, animationInterval;

	// Default settings
	var defaults = {
		// Selectors
		selector: '[data-scroll]',
		ignore: '[data-scroll-ignore]',
		selectorHeader: null,

		// Speed & Easing
		speed: 500,
		offset: 0,
		easing: 'easeInOutCubic',
		easingPatterns: {},

		// Callback API
		before: function () {},
		after: function () {}
	};


	//
	// Methods
	//

	/**
	 * Merge two or more objects. Returns a new object.
	 * @private
	 * @param {Boolean}  deep     If true, do a deep (or recursive) merge [optional]
	 * @param {Object}   objects  The objects to merge together
	 * @returns {Object}          Merged values of defaults and options
	 */
	var extend = function () {

		// Variables
		var extended = {};
		var deep = false;
		var i = 0;
		var length = arguments.length;

		// Check if a deep merge
		if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
			deep = arguments[0];
			i++;
		}

		// Merge the object into the extended object
		var merge = function (obj) {
			for ( var prop in obj ) {
				if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
					// If deep merge and property is an object, merge properties
					if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
						extended[prop] = extend( true, extended[prop], obj[prop] );
					} else {
						extended[prop] = obj[prop];
					}
				}
			}
		};

		// Loop through each object and conduct a merge
		for ( ; i < length; i++ ) {
			var obj = arguments[i];
			merge(obj);
		}

		return extended;

	};

	/**
	 * Get the height of an element.
	 * @private
	 * @param  {Node} elem The element to get the height of
	 * @return {Number}    The element's height in pixels
	 */
	var getHeight = function ( elem ) {
		return Math.max( elem.scrollHeight, elem.offsetHeight, elem.clientHeight );
	};

	/**
	 * Get the closest matching element up the DOM tree.
	 * @private
	 * @param  {Element} elem     Starting element
	 * @param  {String}  selector Selector to match against
	 * @return {Boolean|Element}  Returns null if not match found
	 */
	var getClosest = function ( elem, selector ) {

		// Element.matches() polyfill
		if (!Element.prototype.matches) {
			Element.prototype.matches =
				Element.prototype.matchesSelector ||
				Element.prototype.mozMatchesSelector ||
				Element.prototype.msMatchesSelector ||
				Element.prototype.oMatchesSelector ||
				Element.prototype.webkitMatchesSelector ||
				function(s) {
					var matches = (this.document || this.ownerDocument).querySelectorAll(s),
						i = matches.length;
					while (--i >= 0 && matches.item(i) !== this) {}
					return i > -1;
				};
		}

		// Get closest match
		for ( ; elem && elem !== document; elem = elem.parentNode ) {
			if ( elem.matches( selector ) ) return elem;
		}

		return null;

	};

	/**
	 * Escape special characters for use with querySelector
	 * @private
	 * @param {String} id The anchor ID to escape
	 * @author Mathias Bynens
	 * @link https://github.com/mathiasbynens/CSS.escape
	 */
	var escapeCharacters = function ( id ) {

		// Remove leading hash
		if ( id.charAt(0) === '#' ) {
			id = id.substr(1);
		}

		var string = String(id);
		var length = string.length;
		var index = -1;
		var codeUnit;
		var result = '';
		var firstCodeUnit = string.charCodeAt(0);
		while (++index < length) {
			codeUnit = string.charCodeAt(index);
			// Note: there’s no need to special-case astral symbols, surrogate
			// pairs, or lone surrogates.

			// If the character is NULL (U+0000), then throw an
			// `InvalidCharacterError` exception and terminate these steps.
			if (codeUnit === 0x0000) {
				throw new InvalidCharacterError(
					'Invalid character: the input contains U+0000.'
				);
			}

			if (
				// If the character is in the range [\1-\1F] (U+0001 to U+001F) or is
				// U+007F, […]
				(codeUnit >= 0x0001 && codeUnit <= 0x001F) || codeUnit == 0x007F ||
				// If the character is the first character and is in the range [0-9]
				// (U+0030 to U+0039), […]
				(index === 0 && codeUnit >= 0x0030 && codeUnit <= 0x0039) ||
				// If the character is the second character and is in the range [0-9]
				// (U+0030 to U+0039) and the first character is a `-` (U+002D), […]
				(
					index === 1 &&
					codeUnit >= 0x0030 && codeUnit <= 0x0039 &&
					firstCodeUnit === 0x002D
				)
			) {
				// http://dev.w3.org/csswg/cssom/#escape-a-character-as-code-point
				result += '\\' + codeUnit.toString(16) + ' ';
				continue;
			}

			// If the character is not handled by one of the above rules and is
			// greater than or equal to U+0080, is `-` (U+002D) or `_` (U+005F), or
			// is in one of the ranges [0-9] (U+0030 to U+0039), [A-Z] (U+0041 to
			// U+005A), or [a-z] (U+0061 to U+007A), […]
			if (
				codeUnit >= 0x0080 ||
				codeUnit === 0x002D ||
				codeUnit === 0x005F ||
				codeUnit >= 0x0030 && codeUnit <= 0x0039 ||
				codeUnit >= 0x0041 && codeUnit <= 0x005A ||
				codeUnit >= 0x0061 && codeUnit <= 0x007A
			) {
				// the character itself
				result += string.charAt(index);
				continue;
			}

			// Otherwise, the escaped character.
			// http://dev.w3.org/csswg/cssom/#escape-a-character
			result += '\\' + string.charAt(index);

		}

		return '#' + result;

	};

	/**
	 * Calculate the easing pattern
	 * @private
	 * @link https://gist.github.com/gre/1650294
	 * @param {String} type Easing pattern
	 * @param {Number} time Time animation should take to complete
	 * @returns {Number}
	 */
	var easingPattern = function ( settings, time ) {
		var pattern;

		// Default Easing Patterns
		if ( settings.easing === 'easeInQuad' ) pattern = time * time; // accelerating from zero velocity
		if ( settings.easing === 'easeOutQuad' ) pattern = time * (2 - time); // decelerating to zero velocity
		if ( settings.easing === 'easeInOutQuad' ) pattern = time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time; // acceleration until halfway, then deceleration
		if ( settings.easing === 'easeInCubic' ) pattern = time * time * time; // accelerating from zero velocity
		if ( settings.easing === 'easeOutCubic' ) pattern = (--time) * time * time + 1; // decelerating to zero velocity
		if ( settings.easing === 'easeInOutCubic' ) pattern = time < 0.5 ? 4 * time * time * time : (time - 1) * (2 * time - 2) * (2 * time - 2) + 1; // acceleration until halfway, then deceleration
		if ( settings.easing === 'easeInQuart' ) pattern = time * time * time * time; // accelerating from zero velocity
		if ( settings.easing === 'easeOutQuart' ) pattern = 1 - (--time) * time * time * time; // decelerating to zero velocity
		if ( settings.easing === 'easeInOutQuart' ) pattern = time < 0.5 ? 8 * time * time * time * time : 1 - 8 * (--time) * time * time * time; // acceleration until halfway, then deceleration
		if ( settings.easing === 'easeInQuint' ) pattern = time * time * time * time * time; // accelerating from zero velocity
		if ( settings.easing === 'easeOutQuint' ) pattern = 1 + (--time) * time * time * time * time; // decelerating to zero velocity
		if ( settings.easing === 'easeInOutQuint' ) pattern = time < 0.5 ? 16 * time * time * time * time * time : 1 + 16 * (--time) * time * time * time * time; // acceleration until halfway, then deceleration

		// Custom Easing Patterns
		if ( settings.easingPatterns[settings.easing] ) {
			pattern = settings.easingPatterns[settings.easing]( time );
		}

		return pattern || time; // no easing, no acceleration
	};

	/**
	 * Calculate how far to scroll
	 * @private
	 * @param {Element} anchor The anchor element to scroll to
	 * @param {Number} headerHeight Height of a fixed header, if any
	 * @param {Number} offset Number of pixels by which to offset scroll
	 * @returns {Number}
	 */
	var getEndLocation = function ( anchor, headerHeight, offset ) {
		var location = 0;
		if (anchor.offsetParent) {
			do {
				location += anchor.offsetTop;
				anchor = anchor.offsetParent;
			} while (anchor);
		}
		location = Math.max(location - headerHeight - offset, 0);
		return Math.min(location, getDocumentHeight() - getViewportHeight());
	};

	/**
	 * Determine the viewport's height
	 * @private
	 * @returns {Number}
	 */
	var getViewportHeight = function() {
		return Math.max( document.documentElement.clientHeight, root.innerHeight || 0 );
	};

	/**
	 * Determine the document's height
	 * @private
	 * @returns {Number}
	 */
	var getDocumentHeight = function () {
		return Math.max(
			document.body.scrollHeight, document.documentElement.scrollHeight,
			document.body.offsetHeight, document.documentElement.offsetHeight,
			document.body.clientHeight, document.documentElement.clientHeight
		);
	};

	/**
	 * Convert data-options attribute into an object of key/value pairs
	 * @private
	 * @param {String} options Link-specific options as a data attribute string
	 * @returns {Object}
	 */
	var getDataOptions = function ( options ) {
		return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse( options );
	};

	/**
	 * Get the height of the fixed header
	 * @private
	 * @param  {Node}   header The header
	 * @return {Number}        The height of the header
	 */
	var getHeaderHeight = function ( header ) {
		return !header ? 0 : ( getHeight( header ) + header.offsetTop );
	};

	/**
	 * Bring the anchored element into focus
	 * @private
	 */
	var adjustFocus = function ( anchor, endLocation, isNum ) {

		// Don't run if scrolling to a number on the page
		if ( isNum ) return;

		// Otherwise, bring anchor element into focus
		anchor.focus();
		if ( document.activeElement.id !== anchor.id ) {
			anchor.setAttribute( 'tabindex', '-1' );
			anchor.focus();
			anchor.style.outline = 'none';
		}
		root.scrollTo( 0 , endLocation );

	};

	/**
	 * Start/stop the scrolling animation
	 * @public
	 * @param {Node|Number} anchor  The element or position to scroll to
	 * @param {Element}     toggle  The element that toggled the scroll event
	 * @param {Object}      options
	 */
	smoothScroll.animateScroll = function ( anchor, toggle, options ) {

		// Options and overrides
		var overrides = getDataOptions( toggle ? toggle.getAttribute('data-options') : null );
		var animateSettings = extend( settings || defaults, options || {}, overrides ); // Merge user options with defaults

		// Selectors and variables
		var isNum = Object.prototype.toString.call( anchor ) === '[object Number]' ? true : false;
		var anchorElem = isNum || !anchor.tagName ? null : anchor;
		if ( !isNum && !anchorElem ) return;
		var startLocation = root.pageYOffset; // Current location on the page
		if ( animateSettings.selectorHeader && !fixedHeader ) {
			// Get the fixed header if not already set
			fixedHeader = document.querySelector( animateSettings.selectorHeader );
		}
		if ( !headerHeight ) {
			// Get the height of a fixed header if one exists and not already set
			headerHeight = getHeaderHeight( fixedHeader );
		}
		var endLocation = isNum ? anchor : getEndLocation( anchorElem, headerHeight, parseInt((typeof animateSettings.offset === 'function' ? animateSettings.offset() : animateSettings.offset), 10) ); // Location to scroll to
		var distance = endLocation - startLocation; // distance to travel
		var documentHeight = getDocumentHeight();
		var timeLapsed = 0;
		var percentage, position;

		/**
		 * Stop the scroll animation when it reaches its target (or the bottom/top of page)
		 * @private
		 * @param {Number} position Current position on the page
		 * @param {Number} endLocation Scroll to location
		 * @param {Number} animationInterval How much to scroll on this loop
		 */
		var stopAnimateScroll = function ( position, endLocation, animationInterval ) {
			var currentLocation = root.pageYOffset;
			if ( position == endLocation || currentLocation == endLocation || ( (root.innerHeight + currentLocation) >= documentHeight ) ) {

				// Clear the animation timer
				clearInterval(animationInterval);

				// Bring the anchored element into focus
				adjustFocus( anchor, endLocation, isNum );

				// Run callback after animation complete
				animateSettings.after( anchor, toggle );

			}
		};

		/**
		 * Loop scrolling animation
		 * @private
		 */
		var loopAnimateScroll = function () {
			timeLapsed += 16;
			percentage = ( timeLapsed / parseInt(animateSettings.speed, 10) );
			percentage = ( percentage > 1 ) ? 1 : percentage;
			position = startLocation + ( distance * easingPattern(animateSettings, percentage) );
			root.scrollTo( 0, Math.floor(position) );
			stopAnimateScroll(position, endLocation, animationInterval);
		};

		/**
		 * Set interval timer
		 * @private
		 */
		var startAnimateScroll = function () {
			clearInterval(animationInterval);
			animationInterval = setInterval(loopAnimateScroll, 16);
		};

		/**
		 * Reset position to fix weird iOS bug
		 * @link https://github.com/cferdinandi/smooth-scroll/issues/45
		 */
		if ( root.pageYOffset === 0 ) {
			root.scrollTo( 0, 0 );
		}

		// Run callback before animation starts
		animateSettings.before( anchor, toggle );

		// Start scrolling animation
		startAnimateScroll();

	};

	/**
	 * Handle has change event
	 * @private
	 */
	var hashChangeHandler = function (event) {

		// Get hash from URL
		var hash;
		try {
			hash = escapeCharacters( decodeURIComponent( root.location.hash ) );
		} catch(e) {
			hash = escapeCharacters( root.location.hash );
		}

		// Only run if there's an anchor element to scroll to
		if ( !anchor ) return;

		// Reset the anchor element's ID
		anchor.id = anchor.getAttribute( 'data-scroll-id' );

		// Scroll to the anchored content
		smoothScroll.animateScroll( anchor, toggle );

		// Reset anchor and toggle
		anchor = null;
		toggle = null;

	};

	/**
	 * If smooth scroll element clicked, animate scroll
	 * @private
	 */
	var clickHandler = function (event) {

		// Don't run if right-click or command/control + click
		if ( event.button !== 0 || event.metaKey || event.ctrlKey ) return;

		// Check if a smooth scroll link was clicked
		toggle = getClosest( event.target, settings.selector );
		if ( !toggle || toggle.tagName.toLowerCase() !== 'a' || getClosest( event.target, settings.ignore ) ) return;

		// Only run if link is an anchor and points to the current page
		if ( toggle.hostname !== root.location.hostname || toggle.pathname !== root.location.pathname || !/#/.test(toggle.href) ) return;

		// Get the sanitized hash
		var hash;
		try {
			hash = escapeCharacters( decodeURIComponent( toggle.hash ) );
		} catch(e) {
			hash = escapeCharacters( toggle.hash );
		}

		// If the hash is empty, scroll to the top of the page
		if ( hash === '#' ) {

			// Prevent default link behavior
			event.preventDefault();

			// Set the anchored element
			anchor = document.body;

			// Save or create the ID as a data attribute and remove it (prevents scroll jump)
			var id = anchor.id ? anchor.id : 'smooth-scroll-top';
			anchor.setAttribute( 'data-scroll-id', id );
			anchor.id = '';

			// If no hash change event will happen, fire manually
			// Otherwise, update the hash
			if ( root.location.hash.substring(1) === id ) {
				hashChangeHandler();
			} else {
				root.location.hash = id;
			}

			return;

		}

		// Get the anchored element
		anchor = document.querySelector( hash );

		// If anchored element exists, save the ID as a data attribute and remove it (prevents scroll jump)
		if ( !anchor ) return;
		anchor.setAttribute( 'data-scroll-id', anchor.id );
		anchor.id = '';

		// If no hash change event will happen, fire manually
		if ( toggle.hash === root.location.hash ) {
			event.preventDefault();
			hashChangeHandler();
		}

	};

	/**
	 * On window scroll and resize, only run events at a rate of 15fps for better performance
	 * @private
	 * @param  {Function} eventTimeout Timeout function
	 * @param  {Object} settings
	 */
	var resizeThrottler = function (event) {
		if ( !eventTimeout ) {
			eventTimeout = setTimeout((function() {
				eventTimeout = null; // Reset timeout
				headerHeight = getHeaderHeight( fixedHeader ); // Get the height of a fixed header if one exists
			}), 66);
		}
	};

	/**
	 * Destroy the current initialization.
	 * @public
	 */
	smoothScroll.destroy = function () {

		// If plugin isn't already initialized, stop
		if ( !settings ) return;

		// Remove event listeners
		document.removeEventListener( 'click', clickHandler, false );
		root.removeEventListener( 'resize', resizeThrottler, false );

		// Reset varaibles
		settings = null;
		anchor = null;
		toggle = null;
		fixedHeader = null;
		headerHeight = null;
		eventTimeout = null;
		animationInterval = null;
	};

	/**
	 * Initialize Smooth Scroll
	 * @public
	 * @param {Object} options User settings
	 */
	smoothScroll.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Destroy any existing initializations
		smoothScroll.destroy();

		// Selectors and variables
		settings = extend( defaults, options || {} ); // Merge user options with defaults
		fixedHeader = settings.selectorHeader ? document.querySelector( settings.selectorHeader ) : null; // Get the fixed header
		headerHeight = getHeaderHeight( fixedHeader );

		// When a toggle is clicked, run the click handler
		document.addEventListener( 'click', clickHandler, false );

		// Listen for hash changes
		root.addEventListener('hashchange', hashChangeHandler, false);

		// If window is resized and there's a fixed header, recalculate its size
		if ( fixedHeader ) {
			root.addEventListener( 'resize', resizeThrottler, false );
		}

	};


	//
	// Public APIs
	//

	return smoothScroll;

}));
/**
 * Script initializations
 */

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net', 'www.hulu.com', 'videopress.com/embed/']
});

if ( document.querySelector( 'a[href*="#"]' ) ) {
	smoothScroll.init({
		selector: 'a',
		ignore: '.edd_discount_link'
	});
}