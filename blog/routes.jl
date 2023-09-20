using Genie
using Genie.Router
using Mustache

using Blog.TodosController
route("/todo", TodosController.index)

const viewPath = abspath(joinpath("app/resources/views"))

route("/") do
    layout = Dict(
        "view" => viewPath,
        "layout" => abspath(joinpath(viewPath, "layout"))
    )
    Mustache.render_from_file(
        joinpath(layout["layout"], "app.tpl"),
        Dict(
        "name" => "Vallabh Kansagara",
        "github" => "vrkansagara",
        "showGitHub" => true)
        )
end

# All api routes.
include(joinpath(pwd(), "routes/api.jl"))

# All web routes
include(joinpath(pwd(), "routes/web.jl"))