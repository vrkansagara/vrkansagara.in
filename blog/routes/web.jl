route("/html") do
    serve_static_file("welcome.html")
end

route("/sanskrit") do
    serve_static_file("sanskrit.html")
end