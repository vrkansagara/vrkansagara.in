using Genie
using Genie.Router
using Mustache

route("/") do
    layout = Dict(
        "path" => abspath(joinpath( "resource/views"))
    )
    Mustache.render_from_file(
        joinpath(layout["path"], "layout/app.tpl"),
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