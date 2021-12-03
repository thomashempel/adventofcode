use structopt::StructOpt;

#[derive(StructOpt)]
struct Cli {
  #[structopt(parse(from_os_str))]
  path: std::path::PathBuf
}

fn main()
{
  let args = Cli::from_args();

  let content = std::fs::read_to_string(&args.path)
    .expect("could not read file");

  let mut result: u32 = 0;
  let mut last: u32 = u32::MAX;

  for line in content.lines() {
    let int_line = line.parse::<u32>().unwrap();
    if int_line > last {
      result += 1;
    }
    last = int_line;
  }

  println!("Result: {}", result);
}
