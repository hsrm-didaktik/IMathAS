<?php
//Chat extension

global $allowedmacros;
array_push($allowedmacros,"asciimath2tex", "copyButton", "essayText", "url2openwebui");

require(__DIR__."/../../filter/math/ASCIIMath2TeX.php");

function asciimath2tex($AMstring) {
  $AMT = new AMtoTeX;
	$tex = $AMT->convert($AMstring); //convert ASCIIMath string to TeX
    return "$ $tex $";
}


function copyButton($arg="",$label="Copy to clipboard",$successMessage="Copied to clipboard",$failMessage="Copy failed!",$formatPrompt="") {
  $js_cp="
  <script>
    function reportSuccess (success) {
      let responseDiv=document.getElementById('js_cp_response');
      let response=(success)?'$successMessage':'$failMessage';
      alert(response);
    }
    function fallbackCopyTextToClipboard(text) {
      var textArea = document.createElement('textarea');
      textArea.value = text;
      // Avoid scrolling to bottom
      textArea.style.top = '0';
      textArea.style.left = '0';
      textArea.style.position = 'fixed';
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      try {
        var successful = document.execCommand('copy');
        reportSuccess(successful);
      } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
      }
      document.body.removeChild(textArea);
    }
    async function copyTextToClipboard(textEncoded) {
        var text = '$formatPrompt'+atob(textEncoded);        
        if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
      }
      try {
        await navigator.clipboard.writeText(text).then(function() {
        reportSuccess(true);
        console.log('Async: Copying to clipboard was successful!');
      })} catch (err) {
        reportSuccess(false);
        console.error('Async: Could not copy text: ', err);
      };
    }
    </script>
  ";
  $html = "<button type=\"button\" onclick=\"copyTextToClipboard('" . base64_encode($arg) . "')\">$label</button>";
  return $js_cp.$html;
}

function ascii2texText($ascii) {
  $pos=stripos($ascii,'`');
  if ($pos === false ) {
    return $ascii;
  }
  $parts=explode("`",$ascii);
  $result="";
  for ($i=0; $i<count($parts); $i++) {
    if ($i % 2 == 1) {
      $result.=asciimath2tex($parts[$i]);
    } else {
      $result.=$parts[$i];
    }
  }
  return $result;
}

function essayText($html) {
  $dom = new DOMDocument();
  $html1 = '<html><body><div id="myDiv">'.$html.'</div></body></html>';
  $dom->loadHTML($html1);
  $divTag = $dom->getElementById('myDiv');
  $extractedText = $divTag->textContent;
  return ascii2texText($extractedText);
}

/* The function url2openwebui is used to convert a URL from chatsite format to a format that can be opened in the OpenWebUI. It takes a URL as input and returns a modified URL that can be used to open the content in the OpenWebUI.
If there is a parameter 'prompt=' it is replaced with 'q=' with the same value and the new url is returned.
Otherwise a prompt template is selected depending on the base url and the parameters. The prompt template is then filled with the parameters and the new url is returned.
The parameter 'models=' is retained.
*/
function url2openwebui($url, $openwebuiBaseUrl="https://chatter.dahn-research.de") {
  $parsedUrl = parse_url($url);
  $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . (isset($parsedUrl['path']) ? $parsedUrl['path'] : '');
  parse_str(isset($parsedUrl['query']) ? $parsedUrl['query'] : '', $params);
  
  $path=$parsedUrl['path'];

  $models =[
    '/cgeneral/assistants/Aufgaben-Helfer' => 'aufgaben-helfer',
    '/cgeneral/tasks/Freitext%20kommentieren' => 'professor',
    '/cgeneral/tasks/Freitextantwort%20verbessern' => 'sokrates',
    '/cgeneral/tasks/Ein%20Konzept%20anwenden' => 'mathe-tutor',
    '/cgeneral/assistants/Aufgaben-L%C3%B6ser' => 'aufgaben-lser',
    '/cgeneral/tasks/Anwendungsaufgabe%20erstellen' => 'mathe-tutor',
    '/cgeneral/assistants/Kurs-Helfer' => 'vorkursbegleiter',
    '/cgeneral/assistants/Mathe-Reasoner' => 'mathe-reasoner',
  ];

  $model="openrouter/auto";
  if (isset($models[$path])) {
    $model = $models[$path];
  }

  if (isset($params['prompt'])) {
    $params['q'] = $params['prompt'];
    unset($params['prompt']);
    $params['models'] = rawurlencode($model);
    return $openwebuiBaseUrl ."?". http_build_query($params);
  }

  // Define prompt templates for specific $parsedUrl['path'] values
  $promptTemplates = [
    '/cgeneral/tasks/Freitext%20kommentieren' => "Ich habe die Frage \n\n {{Frage}} \n\n so beantwortet: \n\n {{Antwort}} \n\n Bewerte meine Antwort und gib mir Hinweise, um die Antwort zu verbessern.",
    '/cgeneral/tasks/Freitextantwort%20verbessern' => "Ich habe die Frage \n\n {{Frage}} \n\n so beantwortet: \n\n {{Antwort}} \n\n Hilf mir, die Antwort zu verbessern.",
    '/cgeneral/tasks/Ein%20Konzept%20anwenden' => "Gib mir {{Anzahl}} Beispiele für Anwendungen von {{Konzept}} in {{Gebiet}}. Gib zu jedem Beispiel einen Link zu einer Webseite mit weiteren Informationen.",
    '/cgeneral/tasks/Anwendungsaufgabe%20erstellen' => "Gib mir eine Anwendungsaufgabe aus dem Fachgebiet {{Fachgebiet}}, die ähnlich zu dieser Aufgabe ist:\n\n {{Aufgabe}}\n\nAchte darauf, dass die Parameter der Aufgabe und die Lösung fachlich plausibel sind.",
    // Add more templates as needed
  ];
  
  $template="Wie kannst Du mir helfen?";
  if (isset($promptTemplates[$path])) {
    $template = $promptTemplates[$path];

    $decodedParams = array_map('rawurldecode', $params);
    foreach ($decodedParams as $key => $value) {
      $template = str_replace('{{' . $key . '}}', $value, $template);
    } 
  }
  return "$openwebuiBaseUrl?models=" . rawurlencode($model) . "&q=" . rawurlencode($template);  

}

?>