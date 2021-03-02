<template>
  <div>
    <form id="interpreter_form" autocomplete="off">
      <div id="interpreter_area">
        <div id="interpreter_output" />
      </div>
      <div id="oneline">
        <input id="interpreter_text" name="input_text" type="text" class="textbox" size="100">
      </div>
      <div id="multiline">
        <textarea id="interpreter_textarea" name="input_textarea" type="text" class="textbox" cols="97" rows="10" />
        <br>
      </div>
    </form>

    <div>
      <ul>
        <li>
          To show the signature of a MochiKit function and link
          to its documentation, type help(fn) on any MochiKit
          function.
        </li>
        <li>
          To write multi-line code snippets, use the lower text area
          and press ctrl-enter or cmd-enter to submit.
        </li>
        <li>
          <tt>function name() {}</tt> syntax might not end up in
          window scope, so use <tt>name = function () {}</tt>
          syntax instead
        </li>
        <li>
          If you want to stuff something into the output window
          other than the <tt>repr(...)</tt> of the expression
          result, use the <tt>writeln(...)</tt> function.
          It accepts anything that MochiKit.DOM does, so you can
          even put styled stuff in there!
        </li>
        <li>
          Use <tt>clear()</tt> to clear the interpreter window.
        </li>
        <li>
          You can use <tt>blockOn(aDeferred)</tt> to wait on a
          Deferred.  This expression must be used by itself, so
          the value must be obtained from <tt>_</tt> or
          <tt>last_exc</tt>.  Typing any expression will
          cancel the Deferred.
        </li>
        <li>
          Up and down arrow keys work as a rudimentary history
        </li>
        <li>
          <tt>_</tt> is the value of the last expression
          that was not <tt>undefined</tt>, <tt>last_exc</tt> is
          the value of the last unhandled exception.
        </li>
      </ul>
    </div>
  </div>

</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.');
  },
};
</script>
