using Dates
using Genie.Renderer.Json: json

route("/api") do
    (
        :ack => Dates.now(),
        :message => "Hi there!"
    ) |> json
end