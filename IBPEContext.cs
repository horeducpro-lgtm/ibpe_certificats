using Microsoft.EntityFrameworkCore;
using IBPE.Models;

public class IBPEContext : DbContext
{
    public IBPEContext(DbContextOptions<IBPEContext> options) : base(options) { }

    public DbSet<Candidate> Candidates { get; set; }
    public DbSet<Certificate> Certificates { get; set; }
}
