module TodosController
using Blog.Todos
using Genie.Renderers, Genie.Renderers.Html
function index()
  html(:todos, :index; todos=all(Todo))
end
end